API FUTUR CHATBOT

GET /api/catalog.php
Header obligatoire : X-API-Key: votre_clé

Cette API lit directement MySQL. Après une modification du catalogue dans l'administration, la prochaine requête récupère les nouvelles données.
Avant mise en production, remplacez CHATBOT_API_KEY dans config/config.php par une clé secrète longue.
