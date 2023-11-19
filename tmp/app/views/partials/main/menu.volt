{{ helper.widget('Application').buildMenu("top", 'widget/site-menu') }}
{#   {{ helper.menu.item( helper.translate('Home'), 'index', helper.langUrl(['for':'index']) ) }}
{{ helper.menu.item( helper.translate('Dom'), 'dom', helper.langUrl(['for':'publications', 'type':'dom']), [], [
         helper.menu.item( helper.translate('Contacts'), 'contacts', helper.langUrl(['for':'contacts']) ),
                  helper.menu.item( helper.translate('Contacts'), 'contacts', helper.langUrl(['for':'contacts']) )
    ] ) }}
{{ helper.menu.item( helper.translate('Biznes'), 'biznes', helper.langUrl(['for':'publications', 'type':'biznes']) ) }}
{{ helper.menu.item( helper.translate('Dokumenty'), 'dokumenty', helper.langUrl(['for':'publications', 'type':'dokumenty']) ) }}
{{ helper.menu.item( helper.translate('Contacts'), 'contacts', helper.langUrl(['for':'contacts']) ) }}
{{ helper.menu.item( helper.translate('Admin'), null, url(['for':'admin']), ['li':['class':'last'], 'a':['class':'noajax']] ) }}



{{ helper.menu.item( 'Dom', 'dom', helper.langUrl(['for':'dom']), [],
        [
            helper.menu.item( 'Printing', 'printing', helper.langUrl(['for':'dom']) ),
            helper.menu.item( 'Design', 'design', helper.langUrl(['for':'dom']) )
        ]
        ) }}

#}