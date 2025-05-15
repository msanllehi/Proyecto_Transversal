package com.transversal.opinions.repository;

import com.transversal.opinions.model.ProductDocument;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ProductDocumentRepository extends MongoRepository<ProductDocument, String> {
    
    ProductDocument findByName(String name);
}
