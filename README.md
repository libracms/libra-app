Libra CMS
=======================


##Tasks:
    - Create a dropdown view helper menu for administration layout [NOT STARTED]
    - Configuration page in administration [NOT IMPLEMENTED]
    - Render templates by relative name if it contains in the same level after '/' sign [COMPLETED]


###Routers:
    URI ends at leading '/` or exact page. Like:
        http://extensions.joomla.org/extensions/calendars-a-events/ not */calendars-a-events
        http://prikol.i.ua/lenta/video/     not http://prikol.i.ua/lenta/video
    any module route may has leading '/' with name index like libra-article/index linked to index.php | index.html for google understanding
    Principles: any page should be in one example (only 1 uri).