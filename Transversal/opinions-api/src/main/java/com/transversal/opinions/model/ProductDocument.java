package com.transversal.opinions.model;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import java.util.ArrayList;
import java.util.List;

@Document(collection = "products")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductDocument {
    
    @Id
    private String id;
    
    private String name;
    
    private String description;
    
    private List<OpinionDocument> opinions = new ArrayList<>();
    

    public void addOpinion(OpinionDocument opinion) {
        if (opinions == null) {
            opinions = new ArrayList<>();
        }
        opinions.add(opinion);
    }
}
