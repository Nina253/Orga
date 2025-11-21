library(DBI)
library(jsonlite)
con <- DBI::dbConnect(
  drv = RMySQL::MySQL(),    
  host = "localhost", 
  port = 8889, 
  username = "root", 
  password =  "root",
  dbname = "orga",  
  unix.sock = "/Applications/MAMP/tmp/mysql/mysql.sock",
)
dbListTables(con)
query <- "SELECT h.duree_sommeil, h.duree_travail, h.duree_reseaux, h.freq_sport, s.notes
FROM habitudes h
JOIN scolarite s ON h.id_etu = s.id_etu"
donnes <- dbGetQuery(con, query)
model <- lm(notes ~ duree_sommeil + duree_travail + duree_reseaux + freq_sport, data = donnes)
summary(model)
coeffs <- list(
  sommeil = coef(model)["duree_sommeil"],
  travail = coef(model)["duree_travail"],
  reseaux = coef(model)["duree_reseaux"],
  sport = coef(model)["freq_sport"],
  noteSi0 = coef(model)["(Intercept)"]
)

write_json(coeffs, "/Users/florient/Desktop/coeffs.json", pretty = TRUE)

cat("Coefficients exportés dans coeffs.json\n")