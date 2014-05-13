GifBot
======

<img src="http://hellobold.com/slack/gifbot-logo.gif?new" />

Bump your Slack channels to 11! GifBot is a Slack webhook that inserts random GIF's into any Slack channel. Yes yes, we know you already have GIFs, GifBot just makes it faster, stronger, giffier.

## Installation

Check out this repository to a public-facing web server with PHP.

```
$ git clone https://github.com/bold/GifBot.git
```

Add a new Outgoing Webhook integration with Slack.

```
https://<your_slack_subdomain>.slack.com/services/new/outgoing-webhook
```

Fill out the webhook settings.

<img src="http://hellobold.com/slack/gifbot-setup.jpg" />

You may customize any of the settings to fit what you like best as long and the URL is correctly pointing to the GifBot.php file.

## Usage

Go back to your Slack chats and type "#gif <search_term>" and prosper. Or, just type "#gif" and get yourself a random boost of wonderful.

<img src="http://hellobold.com/slack/gifbot-demo.jpg" />
