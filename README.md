# Pandemic Levyraati
In the beginning of 2020 the whole world locked down and people were not able to leave their homes. During this time, me and two friends began meeting on Saturdays via videochat and rated songs. After doing this for one night and keeping score on an Excel sheet, I thought it would be a cool exercise to create a CRUD application in PHP and MySQL to keep score of the ratings we gave songs. 

I began learning PHP and cobbled the appliation together in a couple of afternoons. Once we tried the site out the next Saturday, it became a hit and we have kept using it ever since. In three years we have rated almost 7000 songs.

The site has been developed ever since, with features being added as users have asked for them. Given that I had no idea we would be using this site for so long or that I would even need to upkeep it, the code is sloppy and spaghettified to a ludicrous degree. I have added features usually while rating songs with my friends, so there was no attempt to do things the "right" way: all we cared about was getting a feature to work. 

I am sharing this not to be some shining example of a coding project, but the exact opposite. I want to show you a project I worked on for years on my spare time that I spent little time worrying about writing code consistently or using best practises. I wanted to create something that works and that my friends could use. Instead of being paralyzed by fear of making mistakes and not writing code properly, I just sat down and wrote something.  

This is the only coding project I worked on in my free time that was directly useful to others and despite it being a mess, it has a special place in my heart. I learned so much working on this site and will know what mistakes to look out for in the future because I made them all here. 

# Overview
The site is a basic CRUD (Create-Read-Update-Delete) site written in PHP that interacts with a MySQL database. All user information and rated songs are stored on the database. There are some sections written in JavaScript to implement user requested features.

The site has a user creation page hidden inside the index page where a user can create a user profile if they know the invitation code. Once a user has created a profile they can post songs to be rated. The song is posted by giving the name of the performer as well as the name of the song and an optional link to the song. We predominantly used YouTube links to share songs. Once a song is posted the users can score the song, giving it a rating from 0-10. A user can rate a song only once and cannot change their rating. (User requested feature).

The site lists all the songs rated and keeps a song up for 24 hours after which the song vanishes from the rating list. A seperate page gived the best and worst song rated in the last 24 hours along with a top 10. 

This site was meant for only myself and 3 friends and so has no limiting features to prevent posting songs endlessly. I had created a fork of this site originally for a more public audience that supported comments, a 24 hour shuffle of posted songs and limited users to posting 1 song a day. 

# Features that have been added over the years
- New user creation page with a definable invite code.
- Various pages with various statistics about songs ratings.
- Various "Best Of" lists, including Best of the Year pages.
- Various user statistics are available.
- Each week a user defines a theme under which songs are listed and themes can be listed in order.
- Songs within themes can be ranked from best to worst.
- A Feature Request system with basic ticketing functions.
- Songs are listed as YouTube links and the site can grab thumbnails of the videos.
- Simple recommendation system based on given scores.

# Ideas for the future
In retrospect, instead of having a 0-10 rating, a thumbs up/thumbs down rating system might be a little better, with double thumbs up/ double thumbs down for songs you really liked. By user request I am retaining the 0-10 rating system though.
I would also like to leverage the YouTube API more to get more information into the Pandemic Levyraati pages.
