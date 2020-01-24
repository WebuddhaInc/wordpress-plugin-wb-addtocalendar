# Wordpress Add To Calendar Button

This plugin provides a shortcode `[addtocalendar]` for inserting an Add To Calendar button within a post.  Add to Calendar buttons may also be created directly from within your PHP library.

# Plugin Installation

Search for "Add to Calendar Button" and install the plugin, or manually upload the `package.zip` file provided in this repository to your Wordpress installer.  Activate the plugin once you've installed the files.
  
# Shortcode Usage

To use the shortcode you will place a version of the following code in a Post or Page of your website.

```
[addtocalendar title="My first event" description="Join me for this great event!" start="2020-01-25 15:00:00" end="2020-01-24 16:30:00" location="Atlanta, GA"]
```

# PHP Method Usage

To generate a calendar button you'll call the `createButton` method on the `wb_addtocalendar` class.

```
echo wb_addtocalendar::getInstance()->createButton([
	'title'       => 'My first event',
	'description' => 'Join me for this great event!',
	'start'       => '2020-01-25 15:00:00',
	'end'         => '2020-01-24 16:30:00',
	'location'    => 'Atlanta, GA'
	]);
```

# Credits

This plugin uses a version of the `carlsednaoui/add-to-calendar-buttons` javascript library.
- https://github.com/carlsednaoui/add-to-calendar-buttons
- https://github.com/WebuddhaInc/add-to-calendar-buttons
