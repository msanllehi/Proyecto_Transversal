package com.transversal.opinions.model;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.util.ArrayList;
import java.util.List;

@Entity
@Table(name = "products")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Product {
    
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    private String name;
    
    private String description;
    
    @OneToMany(mappedBy = "product", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<Opinion> opinions = new ArrayList<>();
    

    public void addOpinion(Opinion opinion) {
        if (opinions == null) {
            opinions = new ArrayList<>();
        }
        opinions.add(opinion);
        opinion.setProduct(this);
    }
}
