package com.transversal.opinions.repository;

import com.transversal.opinions.model.Product;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProductRepository extends JpaRepository<Product, Long> {
    
    @Query("SELECT p FROM Product p LEFT JOIN FETCH p.opinions WHERE p.id = :productId")
    Product findByIdWithOpinions(Long productId);
    
    @Query("SELECT p FROM Product p JOIN p.opinions o GROUP BY p.id ORDER BY AVG(o.rating) DESC")
    List<Product> findAllWithRatingsSorted();
}
