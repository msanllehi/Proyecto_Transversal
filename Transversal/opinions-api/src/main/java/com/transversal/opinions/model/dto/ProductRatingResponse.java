package com.transversal.opinions.model.dto;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductRatingResponse {
    
    private Long productId;
    private String productName;
    private Double weightedRating;
    private Integer totalOpinions;
    private Double averageRating;
}
