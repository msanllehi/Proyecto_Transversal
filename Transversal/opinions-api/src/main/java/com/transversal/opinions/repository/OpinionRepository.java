package com.transversal.opinions.repository;

import com.transversal.opinions.model.Opinion;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface OpinionRepository extends JpaRepository<Opinion, Long> {
    
    List<Opinion> findByProductId(Long productId);
}
