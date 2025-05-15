package com.transversal.opinions.service;

import com.transversal.opinions.model.dto.OpinionRequest;
import com.transversal.opinions.model.dto.OpinionResponse;
import com.transversal.opinions.model.dto.ProductRatingResponse;

import java.util.List;

public interface OpinionService {
    
    List<OpinionResponse> getOpinions(Long productId);
    
    OpinionResponse sendOpinion(Long productId, OpinionRequest opinionRequest);
    
    List<ProductRatingResponse> getRating(int limit);
}
