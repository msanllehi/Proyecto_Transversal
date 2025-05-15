package com.transversal.opinions.controller;

import com.transversal.opinions.model.dto.ApiResponse;
import com.transversal.opinions.model.dto.OpinionRequest;
import com.transversal.opinions.model.dto.OpinionResponse;
import com.transversal.opinions.model.dto.ProductRatingResponse;
import com.transversal.opinions.service.OpinionService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.Parameter;
import io.swagger.v3.oas.annotations.tags.Tag;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api/opinions")
@Tag(name = "Opinions API")
public class OpinionController {

    private final OpinionService jpaOpinionService;
    private final OpinionService jdbcOpinionService;
    private final OpinionService mongoOpinionService;
    
    public OpinionController(
            @Qualifier("jpaOpinionService") OpinionService jpaOpinionService,
            @Qualifier("jdbcOpinionService") OpinionService jdbcOpinionService,
            @Qualifier("mongoOpinionService") OpinionService mongoOpinionService) {
        this.jpaOpinionService = jpaOpinionService;
        this.jdbcOpinionService = jdbcOpinionService;
        this.mongoOpinionService = mongoOpinionService;
    }
    
    @GetMapping("/{productId}")
    @Operation
    public ResponseEntity<ApiResponse<List<OpinionResponse>>> getOpinions(
            @PathVariable Long productId,
            @RequestParam(defaultValue = "jpa") String dbType) {
        
        try {
            List<OpinionResponse> opinions;
            
            switch (dbType.toLowerCase()) {
                case "jdbc":
                    opinions = jdbcOpinionService.getOpinions(productId);
                    break;
                case "mongo":
                    opinions = mongoOpinionService.getOpinions(productId);
                    break;
                case "jpa":
                default:
                    opinions = jpaOpinionService.getOpinions(productId);
                    break;
            }
            
            return ResponseEntity.ok(ApiResponse.success(opinions));
        } catch (Exception e) {
            return ResponseEntity
                    .status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body(ApiResponse.error("Error retrieving opinions: " + e.getMessage()));
        }
    }
    
    @PostMapping("/{productId}")
    @Operation
    public ResponseEntity<ApiResponse<OpinionResponse>> sendOpinion(
            @PathVariable Long productId,
            @Valid @RequestBody OpinionRequest opinionRequest,
            @RequestParam(defaultValue = "jpa") String dbType) {
        
        try {
            OpinionResponse opinion;
            
            // Using JPA by default
            opinion = jpaOpinionService.sendOpinion(productId, opinionRequest);
            
            return ResponseEntity
                    .status(HttpStatus.CREATED)
                    .body(ApiResponse.success("Opinion created successfully", opinion));
        } catch (Exception e) {
            return ResponseEntity
                    .status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body(ApiResponse.error("Error creating opinion: " + e.getMessage()));
        }
    }
    
    @GetMapping("/rating")
    @Operation
    public ResponseEntity<ApiResponse<List<ProductRatingResponse>>> getRating(
            @Parameter
            @RequestParam(defaultValue = "10") int limit) {
        
        try {
            // Using JPA for ratings
            List<ProductRatingResponse> ratings = jpaOpinionService.getRating(limit);
            
            return ResponseEntity.ok(ApiResponse.success(ratings));
        } catch (Exception e) {
            return ResponseEntity
                    .status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body(ApiResponse.error("Error retrieving ratings: " + e.getMessage()));
        }
    }
}
