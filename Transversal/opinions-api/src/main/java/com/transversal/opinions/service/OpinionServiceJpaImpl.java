package com.transversal.opinions.service;

import com.transversal.opinions.model.Opinion;
import com.transversal.opinions.model.Product;
import com.transversal.opinions.model.dto.OpinionRequest;
import com.transversal.opinions.model.dto.OpinionResponse;
import com.transversal.opinions.model.dto.ProductRatingResponse;
import com.transversal.opinions.repository.OpinionRepository;
import com.transversal.opinions.repository.ProductRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.EntityNotFoundException;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.stream.Collectors;

@Service("jpaOpinionService")
public class OpinionServiceJpaImpl implements OpinionService {

    private final ProductRepository productRepository;
    private final OpinionRepository opinionRepository;
    

    private final int MIN_VOTES_FOR_CONFIDENCE = 5;
    
    @Autowired
    public OpinionServiceJpaImpl(ProductRepository productRepository, OpinionRepository opinionRepository) {
        this.productRepository = productRepository;
        this.opinionRepository = opinionRepository;
    }

    @Override
    @Transactional(readOnly = true)
    public List<OpinionResponse> getOpinions(Long productId) {
        List<Opinion> opinions = opinionRepository.findByProductId(productId);
        return opinions.stream()
                .map(OpinionResponse::fromEntity)
                .collect(Collectors.toList());
    }

    @Override
    @Transactional
    public OpinionResponse sendOpinion(Long productId, OpinionRequest opinionRequest) {
        Product product = productRepository.findById(productId)
                .orElseThrow(() -> new EntityNotFoundException("Product not found with id: " + productId));
                
        Opinion opinion = new Opinion();
        opinion.setUsername(opinionRequest.getUsername());
        opinion.setRating(opinionRequest.getRating());
        opinion.setComment(opinionRequest.getComment());
        opinion.setProduct(product);
        
        opinion = opinionRepository.save(opinion);
        return OpinionResponse.fromEntity(opinion);
    }

    @Override
    @Transactional(readOnly = true)
    public List<ProductRatingResponse> getRating(int limit) {
        List<Product> products = productRepository.findAll();
        List<ProductRatingResponse> ratings = new ArrayList<>();
        

        double globalAverageRating = calculateGlobalAverageRating(products);
        
        for (Product product : products) {
            if (product.getOpinions() != null && !product.getOpinions().isEmpty()) {
                int totalOpinions = product.getOpinions().size();
                double averageRating = product.getOpinions().stream()
                        .mapToInt(Opinion::getRating)
                        .average()
                        .orElse(0.0);
                

                double weightedRating = calculateBayesianRating(
                        averageRating, 
                        totalOpinions, 
                        MIN_VOTES_FOR_CONFIDENCE, 
                        globalAverageRating
                );
                
                ProductRatingResponse ratingResponse = new ProductRatingResponse(
                        product.getId(),
                        product.getName(),
                        weightedRating,
                        totalOpinions,
                        averageRating
                );
                
                ratings.add(ratingResponse);
            }
        }
        

        return ratings.stream()
                .sorted(Comparator.comparing(ProductRatingResponse::getWeightedRating).reversed())
                .limit(limit > 0 ? limit : 10)
                .collect(Collectors.toList());
    }
    
    // Calculate global average rating across all products
    private double calculateGlobalAverageRating(List<Product> products) {
        double sum = 0;
        int count = 0;
        
        for (Product product : products) {
            if (product.getOpinions() != null) {
                for (Opinion opinion : product.getOpinions()) {
                    sum += opinion.getRating();
                    count++;
                }
            }
        }
        
        return count > 0 ? sum / count : 0;
    }
    
    // Calculate Bayesian weighted rating
    private double calculateBayesianRating(double averageRating, int totalVotes, int minVotesForConfidence, double globalAverage) {






        return ((double) totalVotes / (totalVotes + minVotesForConfidence)) * averageRating +
               ((double) minVotesForConfidence / (totalVotes + minVotesForConfidence)) * globalAverage;
    }
}
