package com.transversal.opinions.service;

import com.transversal.opinions.model.OpinionDocument;
import com.transversal.opinions.model.ProductDocument;
import com.transversal.opinions.model.dto.OpinionRequest;
import com.transversal.opinions.model.dto.OpinionResponse;
import com.transversal.opinions.model.dto.ProductRatingResponse;
import com.transversal.opinions.repository.ProductDocumentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.stream.Collectors;

@Service("mongoOpinionService")
public class OpinionServiceMongoImpl implements OpinionService {
    
    private final ProductDocumentRepository productRepository;
    

    private final int MIN_VOTES_FOR_CONFIDENCE = 5;
    
    @Autowired
    public OpinionServiceMongoImpl(ProductDocumentRepository productRepository) {
        this.productRepository = productRepository;
    }

    @Override
    public List<OpinionResponse> getOpinions(Long productId) {
        ProductDocument product = productRepository.findById(productId.toString())
                .orElseThrow(() -> new RuntimeException("Product not found with id: " + productId));
                
        return product.getOpinions().stream()
                .map(OpinionResponse::fromDocument)
                .collect(Collectors.toList());
    }

    @Override
    public OpinionResponse sendOpinion(Long productId, OpinionRequest opinionRequest) {
        ProductDocument product = productRepository.findById(productId.toString())
                .orElseThrow(() -> new RuntimeException("Product not found with id: " + productId));
        
        OpinionDocument opinion = new OpinionDocument(
                opinionRequest.getUsername(),
                opinionRequest.getRating(),
                opinionRequest.getComment()
        );
        
        product.addOpinion(opinion);
        product = productRepository.save(product);
        

        return OpinionResponse.fromDocument(opinion);
    }

    @Override
    public List<ProductRatingResponse> getRating(int limit) {
        List<ProductDocument> products = productRepository.findAll();
        List<ProductRatingResponse> ratings = new ArrayList<>();
        

        double globalAverageRating = calculateGlobalAverageRating(products);
        
        for (ProductDocument product : products) {
            if (product.getOpinions() != null && !product.getOpinions().isEmpty()) {
                int totalOpinions = product.getOpinions().size();
                double averageRating = product.getOpinions().stream()
                        .mapToInt(OpinionDocument::getRating)
                        .average()
                        .orElse(0.0);
                

                double weightedRating = calculateBayesianRating(
                        averageRating, 
                        totalOpinions, 
                        MIN_VOTES_FOR_CONFIDENCE, 
                        globalAverageRating
                );
                
                ProductRatingResponse ratingResponse = new ProductRatingResponse(
                        Long.valueOf(product.getId()),
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
    private double calculateGlobalAverageRating(List<ProductDocument> products) {
        double sum = 0;
        int count = 0;
        
        for (ProductDocument product : products) {
            if (product.getOpinions() != null) {
                for (OpinionDocument opinion : product.getOpinions()) {
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
