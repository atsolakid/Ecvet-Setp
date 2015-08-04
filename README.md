# ecvet-step.eu

Website of the **"ECVET STEP"** project, live at: http://ecvet-step.eu

## Installation


**Requirements:**

* nginx (or apache)
* php5 
* mariadb (or mysql)

The following instructions apply for a typical arch-linux installation:

```sh
systemctl start mysqld.service
systemctl start php5-fpm.service
systemctl start nginx.service
```

In case you need to import the database, you need to issue the following commands:

```sh
gunzip ecvet_step.sql.gz
mysql -u <user> -p

> provide the password for <user>

create database ecvet_step_eu;
use  ecvet_step_eu
source ecvet_step.sql;
quit
```

To get the content of the site:

```
rsync -avz hq.ecvet-step.eu:/home/tkout/dev/ecvet-step-eu/wp-content/uploads .
```

or get a snapshot from: http://ecvet-step.eu/uploads.tgz

*NOTE:* most URLs will appear broken, best approach to fix this while working on your dev workstation is to add a "mock" entry in the `/etc/hosts` file, i.e:  `127.0.0.1       ecvet-step.eu`



## Main components


### Structure

> (from project_website_guidelines_en.pdf)

* Homepage
* Project Overview
* Consortium
* Management Structure
* Scientific Methodology and Work Packages
* Case Studies
* Deliverables and Publications
* Events
* Media centre
* Glossary


**Consortium:** Include a list of partners with their country of origin, logo, principle scientific contact person and website address. Please update if new parties join the consortium. *A map* showing the geographical distribution of the participating institutions should also be included.

```
1. Homepage
2. Project overview
    a. Vision
    b. Aim and objectives
    c. Audience and expected impact
    d. Scientific methodology
    e. Work-packages
3. Consortium
    a. Overview (with a map)
    b. One page per partner
4. Case Studies
    a. Overview
    b. One page per different stakeholders
5. Blog / News
6. Events
7. Questions and Answers (Discussion)
8. Media Center
    a. Project flyers
    b. Deliverables
    c. Newsletter (?)
    d. Presentations
    e. Publications
9. Links
```


#### Secondary Menu

1. Search box
2. RSS/Atom Feed
3. Sitemap
4. Contact (link to a contact form that will allow visitors to provide feedback or request further information).
5. Glossary
6. Disclaimer
7. Headquarters (intranet)

#### Footer

> (from project_website_guidelines_en.pdf)

"This project is supported by the European Commission under the Environment (including climate change) Theme of the 7 th Framework Programme for Research and Technological Development".

* **Compliance Logos**
  - W3C XHTML 1.0
  - W3C CSS
  - WCAG 2.0
  - CC-BY



### Post formats

> http://codex.wordpress.org/Post_Formats

* aside - Typically styled without a title. Similar to a Facebook note update.
* gallery - A gallery of images. Post will likely contain a gallery shortcode and will have image attachments.
* link - A link to another site. Themes may wish to use the first `<a href=””>` tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it.
* image - A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image.
* quote - A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title.
* status - A short status update, similar to a Twitter status update.
* video - A single video or video playlist. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin).
* audio - An audio file or playlist. Could be used for Podcasting.
* chat - A chat transcript, like so: 


#### Analytics

```html
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47075667-2', 'auto');
  ga('send', 'pageview');

</script>
```



### Colofon

```
Project No. 539816-LLP-1-2013-1-GR-LEONARDO-LMP

DEVELOPMENT OF INNOVATION, LEONARDO DA VINCI 
LIFELONG LEARNING PROGRAMME
ECVET STEP (Project Number 539816-LLP-1-2013-1-GR-LEONARDO-LMP)
Project Number: 539816-LLP-1-2013-1-GR-LEONARDO-LMP
* __Period:__ 01/01/2014 - 31/12/2015
```


### LOGOs

* html5
* css
* accessibility
* cc by

#### HTML5

```html
<a href="http://www.w3.org/html/logo/">
<img src="html5-badge-h-css3-device-multimedia-performance-semantics.png" width="261" height="64" alt="HTML5 Powered with CSS3 / Styling, Device Access, Multimedia, Performance &amp; Integration, and Semantics" title="HTML5 Powered with CSS3 / Styling, Device Access, Multimedia, Performance &amp; Integration, and Semantics">
</a>
```

#### CSS

```html
<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10-blue.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88"></a>
 &nbsp;&nbsp;<a href="http://jigsaw.w3.org/css-validator/check/referer">
    <img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valido!">
</a>
```


#### Creative Commons

```html
 <img src="img/footer-cc.png" alt="Creative Commons" height="32" width="88">
 <p>Except where otherwise noted, content on this site is licensed under a Creative Commons<br><a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons Attribution 3.0 License">Attribution 3.0 License</a></p>
```

#### WCAG

```html
<a href="http://www.w3.org/WAI/WCAG1AA-Conformance"
      title="Explanation of Level Double-A Conformance">
  <img height="32" width="88" 
          src="http://www.w3.org/WAI/wcag1AA"
          alt="Level Double-A conformance icon, 
          W3C-WAI Web Content Accessibility Guidelines 1.0"></a>
```
