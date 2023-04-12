
DROP TABLE IF EXISTS browser_search_analytics;

CREATE TABLE browser_search_analytics (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  remote_ip VARCHAR(255),
  search_terms VARCHAR(255),
  created_at DATETIME, 
  updated_at DATETIME
);



