# Compass is a great cross-platform tool for compiling SASS. 
# This compass config file will allow you to quickly dive right in.
# For more info about compass + SASS: http://net.tutsplus.com/tutorials/html-css-techniques/using-compass-and-sass-for-css-in-your-next-project/

# 1. Set this to the root of your project when deployed:
http_path = "/"

# 2. probably don't need to touch these
css_dir = "../css"
sass_dir = "./"
images_dir = "../images"
javascripts_dir = "../js"
relative_assets = true

# 3. Settings for development - enable if desired
# environment = :development
# output_style = :expanded
# line_comments = true

# 4. Settings for production
environment = :production
output_style = :compressed
line_comments = false

# don't touch this
preferred_syntax = :scss