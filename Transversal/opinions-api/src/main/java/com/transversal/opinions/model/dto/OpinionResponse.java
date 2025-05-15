package com.transversal.opinions.model.dto;

import com.transversal.opinions.model.Opinion;
import com.transversal.opinions.model.OpinionDocument;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OpinionResponse {
    
    private String username;
    private Integer rating;
    private String comment;
    private LocalDateTime date;
    
    // Convert from JPA entity
    public static OpinionResponse fromEntity(Opinion opinion) {
        OpinionResponse response = new OpinionResponse();
        response.setUsername(opinion.getUsername());
        response.setRating(opinion.getRating());
        response.setComment(opinion.getComment());
        response.setDate(opinion.getDate());
        return response;
    }
    
    // Convert from MongoDB document
    public static OpinionResponse fromDocument(OpinionDocument document) {
        OpinionResponse response = new OpinionResponse();
        response.setUsername(document.getUsername());
        response.setRating(document.getRating());
        response.setComment(document.getComment());
        response.setDate(document.getDate());
        return response;
    }
}
