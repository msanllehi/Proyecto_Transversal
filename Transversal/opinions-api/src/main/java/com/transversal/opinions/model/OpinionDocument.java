package com.transversal.opinions.model;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OpinionDocument {
    
    private String username;
    
    private Integer rating;
    
    private String comment;
    
    private LocalDateTime date;
    
    public OpinionDocument(String username, Integer rating, String comment) {
        this.username = username;
        this.rating = rating;
        this.comment = comment;
        this.date = LocalDateTime.now();
    }
}
