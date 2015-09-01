# ItemSenpai #
Website: [www.itemsenpai.xyz](http://www.itemsenpai.xyz)

ItemSenpai is a website that provides you with everything you want from League of Legends item sets!

Want to have some __fun__? Sure! Get some itemsets with __random builds__, __various user-commited item builds__ or __team comps__! Build the items from the sets and have fun with your friends while playing seriously OP builds like AD Thresh!

Want to __improve__ your game? Well of course! One way to improve it would definitely be with downloading the best __winrate & most frequent items__ and __itemsets for specific roles__! No more people telling you what to buy or looking it up on other sites!

The website was built for the [Riot Games API Challenge 2.0](https://developer.riotgames.com/discussion/announcements/show/2lxEyIcE)

## Frameworks used ##
For the backend, we used [Laravel](http://laravel.com/), a PHP MVC framework and or the frontend, we used [AngularJS](https://angularjs.org/)

Hosting was provided by [OpenShift](https://www.openshift.com/), which allowed to install Laravel with [OpenShift
QuickStart](https://hub.openshift.com/quickstarts/115-laravel-5-0)

## Installation on your own system ##
In order to run this website, you need to have PHP 5.4 (with some [extensions](http://laravel.com/docs/5.0#server-requirements)) and MySQL 5.5 installed. 
If you have problems running the application this way, you can also try installing [Laravel Homestead](http://laravel.com/docs/5.0/homestead), which I used myself and there shouldn't be any problems.

You also need to tell Laravel how to use the database. You can do this by editing the .env file in the root directory and change the appropriate settings.
After that, you should run the command php artisan migrate, which will create the database tables.
Once your database was built, you can seed it by going to (application root url)/api/filldata and clicking the links in the order displayed - click the link, wait for it to load, and then click the next one.
The project should be setup after that. Contact me if you have any questions.

## What is where? ##
### Directory structure ###
[Laravel structure](http://laravel.com/docs/5.0/structure)
The folder app/ contains the models (for example, Item.php), the router (app/Http/routes.php) and controllers in (app/Http/Controllers).
The folder database/migrations contains the migration files that will be run after you launch php artisan migrate.
The folder public contains the views (public/pages) and js files, used by angular (public/js/app.js).
The folder storage/fill contains the json files for the special fun builds and team comps Anverid prepared.

### Routing ###
The root addresses are handled by Angular (/, /fun, /fun/rolebuilds ...) and are displayed to the user, therefore you should be able to see the most of it just by clicking stuff on the website.
The api addresses, handled by Laravel, are there to see the data that was received from Riot Games API and use it. You can see the routes and controllers (app/Http/Controllers) used in the app/Http/routes.php file.

## Why is the project not completely done? ##
Oh, you've noticed it? There's a lot of data, that is processed in the backend but doesn't see the light yet (all of the improve part). The answer is simple: I ran out of time.

There are multiple factors which contributed to me not being able to finish it on time.
- Underestimation of the size of the project and the time given
- Lack of Laravel and Angular knowledge (only my second project using them)
- Working as a part timer every day for 8 hours
- LCS Playoffs (seriously, Riot, thanks for distracting me! ;) )
- Party IP rewards (again, thanks for making me miss most of it ;) )

Even though I couldn't finish it in time, I plan on continuing the project after the winners are announced. I think it's a pretty good idea overall and I wonder if I would be able to get any visitors.

### Why was the last version comitted late to the GitHub repo? ###
I am really sorry. I'm not used to the whole git & github thing, especially with mixing it with OpenShift, which uses git as well. 
When I tried to commit it the first time, it didnt commit the whole directory. So after spending a lot of precious time with it, I found a good tutorial on OpenShift's help pages and I was finally able to do it. Yay!

## Conclusion ##
I think the overall idea of the project has the potential to be the best. However, I wasn't able to do all the things I wanted and would probably need a few days more in order to finish it.
I don't doubt that there are many better looking projects out there. And I really wanted the Windows Surface because I was just planning on buying it. Oh well.

Still, with each project you learn something new. And this one is no exception. I have gained experience in
- E-R Models
- Laravel
- Riot Games API
- Angular 
which is always welcome.

Many thanks to Anverid, the other team member, which was able to do his work on time - finding the funny team comps and builds, item sets for roles and other content related jobs in time.