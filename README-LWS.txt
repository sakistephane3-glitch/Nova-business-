NOVA BUSINESS — INSTALLATION LWS

1. Créer une base MySQL sur LWS.
2. Importer database/schema.sql dans phpMyAdmin.
3. Modifier config/config.php avec DB_HOST, DB_NAME, DB_USER et DB_PASS.
4. Envoyer le contenu de nova-business-site/ dans public_html (ou le dossier web de votre domaine).
5. Vérifier que uploads/ et ses sous-dossiers sont accessibles en écriture par PHP.
6. Ouvrir /admin/setup.php et créer le premier compte administrateur (mot de passe >= 8 caractères).
7. Se connecter à /admin/.
8. Remplacer le nom, logo, téléphone et WhatsApp dans Paramètres.
9. Ajouter les produits, plusieurs photos, prix, kits, témoignages et FAQ depuis l'administration.

IMPORTANT : supprimer ou renommer admin/setup.php après création du premier compte.
Ne partagez jamais votre mot de passe LWS ou MySQL.

CHATBOT : /api/catalog.php lit directement les données MySQL avec X-API-Key. Ainsi les changements de prix, description, disponibilité, produits et kits sont immédiatement disponibles pour le futur chatbot.
