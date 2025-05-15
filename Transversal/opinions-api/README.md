# Opinions REST API

This is a REST API for managing product opinions. It allows you to insert and retrieve user opinions about products, as well as get product ratings using Bayesian average.

## Project Structure

- **Model**: Contains JPA entities (Product, Opinion) and MongoDB documents (ProductDocument, OpinionDocument).
- **DTO**: Contains data transfer objects for API requests and responses.
- **Repository**: Contains Spring Data JPA repositories and MongoDB repositories.
- **Service**: Contains service interfaces and implementations (JPA, JDBC, MongoDB).
- **Controller**: Contains REST controllers for handling API endpoints.

## Database Implementation

The API supports three different database implementations:
- **JPA**: Using Spring Data JPA with Hibernate for ORM.
- **JDBC**: Using Spring JDBC Template for direct database access.
- **MongoDB**: Using Spring Data MongoDB for document-based storage.

## Endpoints

### Get Opinions
- **Endpoint**: GET /api/opinions/{productId}
- **Description**: Retrieves all opinions for a specific product.
- **Query Parameter**: dbType - Choose database implementation (jpa, jdbc, mongo)

### Send Opinion
- **Endpoint**: POST /api/opinions/{productId}
- **Description**: Creates a new opinion for a specific product.
- **Body**: OpinionRequest with username, rating, and comment.

### Get Rating
- **Endpoint**: GET /api/opinions/rating
- **Description**: Retrieves products sorted by their weighted rating.
- **Query Parameter**: limit - Number of products to return.

## Bayesian Average Implementation

The getRating endpoint uses a Bayesian average formula to calculate weighted ratings for products. This is implemented as:

```
weighted_rating = (v / (v + m)) * R + (m / (v + m)) * C
```

Where:
- R is the average rating of the product
- v is the number of ratings for the product
- m is the minimum number of ratings to be considered "trustworthy" (set to 5)
- C is the global average rating across all products

This formula helps balance between high ratings with few votes and moderate ratings with many votes.

## Running the Project

1. Ensure MySQL and MongoDB are running locally
2. Configure database settings in application.properties
3. Run the application using Spring Boot
4. Access the Swagger UI at /swagger-ui.html
