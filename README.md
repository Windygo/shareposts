# shareposts
Built from scratch (no frameworksl, pakcagese etc.) PHP MVC with CRUD posts application on top of it

#Local Installation

1. To run locally please download and move under <your drive>/xampp/htdocs/shareposts
2. Create a db called shareposts (or any other name)
3. Update settings on /config/config.php to match you db name, user name etc.

  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', '');
  define('DB_PASS', '');
  define('DB_NAME', 'shareposts');
  
4. Review other settings on config.php and change if needed  
5. Import attached .sql into fresh db
6. Register your own users and create your own posts
7. Try creating two users or more to see how they interact

#Overview
This simple web app, sharedposts, runs on a from scratch super light mvc framework.
Both the mvc and web app can be extended to run much bigger apps based on the existing foundation.

#Functionality
1. Users can register and login
2. Logged in users can add / edit / delete their own posts
3. Logged in users can view posts by all other users
4. Flash messages provide feedback to users




