# Wordpress functions File

This wordpress file is an excerpt from the current iteration of the incomplete MEP Brothers website, due to be released in late 2020.

This file includes mostly edits to the woocommerce actions to properly display the site as intended by the final design. The remaining site features on other pages are not included since they do not add any code value. 

Near the bottom includes a piece of code that also allows the woocommerce system to pull pricing from an off-site database, and include that live price information on the site. This price information is designed to be live, although it includes a session variable storage with automated expiry to allow the site to limit the database calls made per site refresh. 