GifBot
======

Bump your Slack channels to 11! GifBot is a Slack webhook that inserts random GIF's into to any Slack channel. Yes yes, we know you already have GIF's, GifBot just makes it faster, stronger, giffier.

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

Now, go back to your Slack chats type #gif search_term and propser.

<img src="http://hellobold.com/slack/gifbot-demo.jpg" />
