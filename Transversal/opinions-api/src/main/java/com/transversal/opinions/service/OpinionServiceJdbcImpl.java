package com.transversal.opinions.service;

import com.transversal.opinions.model.dto.OpinionRequest;
import com.transversal.opinions.model.dto.OpinionResponse;
import com.transversal.opinions.model.dto.ProductRatingResponse;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.GeneratedKeyHolder;
import org.springframework.jdbc.support.KeyHolder;
import org.springframework.stereotype.Service;

import java.sql.PreparedStatement;
import java.sql.Statement;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

@Service("jdbcOpinionService")
public class OpinionServiceJdbcImpl implements OpinionService {

    private final JdbcTemplate jdbcTemplate;
    

    private final int MIN_VOTES_FOR_CONFIDENCE = 5;
    
    @Autowired
    public OpinionServiceJdbcImpl(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    @Override
    public List<OpinionResponse> getOpinions(Long productId) {
        String sql = "SELECT id, username, rating, comment, date FROM opinions WHERE product_id = ?";
        
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            OpinionResponse response = new OpinionResponse();
            response.setUsername(rs.getString("username"));
            response.setRating(rs.getInt("rating"));
            response.setComment(rs.getString("comment"));
            response.setDate(rs.getObject("date", LocalDateTime.class));
            return response;
        }, productId);
    }

    @Override
    public OpinionResponse sendOpinion(Long productId, OpinionRequest opinionRequest) {
        String checkProductSql = "SELECT COUNT(*) FROM products WHERE id = ?";
        Integer count = jdbcTemplate.queryForObject(checkProductSql, Integer.class, productId);
        
        if (count == null || count == 0) {
            throw new RuntimeException("Product not found with id: " + productId);
        }
        
        String sql = "INSERT INTO opinions (username, rating, comment, date, product_id) VALUES (?, ?, ?, ?, ?)";
        LocalDateTime now = LocalDateTime.now();
        
        KeyHolder keyHolder = new GeneratedKeyHolder();
        
        jdbcTemplate.update(connection -> {
            PreparedStatement ps = connection.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
            ps.setString(1, opinionRequest.getUsername());
            ps.setInt(2, opinionRequest.getRating());
            ps.setString(3, opinionRequest.getComment());
            ps.setObject(4, now);
            ps.setLong(5, productId);
            return ps;
        }, keyHolder);
        
        OpinionResponse response = new OpinionResponse();
        response.setUsername(opinionRequest.getUsername());
        response.setRating(opinionRequest.getRating());
        response.setComment(opinionRequest.getComment());
        response.setDate(now);
        
        return response;
    }

    @Override
    public List<ProductRatingResponse> getRating(int limit) {

        String globalAvgSql = "SELECT AVG(rating) FROM opinions";
        Double avgRating = jdbcTemplate.queryForObject(globalAvgSql, Double.class);

        final double globalAverageRating = (avgRating != null) ? avgRating : 0.0;
        

        String sql = "SELECT p.id as product_id, p.name as product_name, " +
                     "AVG(o.rating) as avg_rating, COUNT(o.id) as total_opinions " +
                     "FROM products p JOIN opinions o ON p.id = o.product_id " +
                     "GROUP BY p.id, p.name";
                     
        List<ProductRatingResponse> ratings = new ArrayList<>();
        
        jdbcTemplate.query(sql, (rs) -> {
            Long productId = rs.getLong("product_id");
            String productName = rs.getString("product_name");
            Double averageRating = rs.getDouble("avg_rating");
            Integer totalOpinions = rs.getInt("total_opinions");
            
            double weightedRating = calculateBayesianRating(
                    averageRating, 
                    totalOpinions, 
                    MIN_VOTES_FOR_CONFIDENCE, 
                    globalAverageRating
            );
            
            ProductRatingResponse rating = new ProductRatingResponse(
                    productId,
                    productName,
                    weightedRating,
                    totalOpinions,
                    averageRating
            );
            
            ratings.add(rating);
        });
        

        ratings.sort((a, b) -> Double.compare(b.getWeightedRating(), a.getWeightedRating()));
        
        if (limit > 0 && limit < ratings.size()) {
            return ratings.subList(0, limit);
        }
        
        return ratings;
    }
    

    private double calculateBayesianRating(double averageRating, int totalVotes, int minVotesForConfidence, double globalAverage) {






        return ((double) totalVotes / (totalVotes + minVotesForConfidence)) * averageRating +
               ((double) minVotesForConfidence / (totalVotes + minVotesForConfidence)) * globalAverage;
    }
}
