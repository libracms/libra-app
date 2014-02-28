Libra Application
=======================

##Tasks:
- Create a dropdown view helper menu for administration layout [Partial completed]
- Configuration page in administration [Partial completed]
- Render templates by relative name if it contains in the same level after '/' sign [COMPLETED]


###Routers:
URI can ends at leading '/` or not.  
Principles: any page should be in one example (only 1 uri).

###Install changes
From 0.4.1 it became lightweighter by move JS library from requires to suggested.  
So you can include them by changing layout page to your demands.  
The list:

- libra/jquery-assets
- libra/jquery-ui-assets (While, it's not in use)
- libra/twitter-bootstrap-assets
- libra/fancybox-assets

Libra CMS repo contains them by default.

###Udater
```
bin/application updater update 0.3.5
```

###Features
####Fast view of README.md
Possible to view README of any project by any of this urls:

- http://libra-cms/libra-app/markdown?file=vendor/libra/libra-app/README.md
- http://libra-cms/libra-app/markdown?file=vendor/libra/libra-app/README

or simply

- http://libra-cms/libra-app/markdown?file=vendor/libra/libra-app

It looks for file __README.md__ in that folder.
