<?php

namespace App\Services;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;

class DiscordService
{
    /** @var Discord */
    private Discord $discord;

    /** @var ApiService */
    private ApiService $apiService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->discord = new Discord([
            'token' => getenv('TOKEN_BOT'),
            'intents' => [
                Intents::GUILDS,
                Intents::GUILD_PRESENCES,
                Intents::GUILD_MEMBERS,
                Intents::GUILD_MESSAGES,
                Intents::MESSAGE_CONTENT
            ],
            'pmChannels' => true
        ]);

        $this->apiService = new ApiService();
    }

    /**
     * Return a loop
     *
     * @return void
     */
    public function run()
    {
        $this->prepareEvents();

        return $this->discord->run();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function prepareEvents()
    {
        $responses = $this->apiService->flirts();

        $flirts = $responses[0]['flirts'];

        $this->discord->on('ready', function (Discord $discord) use ($flirts) {
            echo "Bot is ready!", PHP_EOL;

            $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) use ($flirts) {
                if ($message->author->bot) {
                    return;
                }

                echo "{$message->author->username}: {$message->content}", PHP_EOL;

                if ($message->content == '!cantada') {
                    // $message->reply('_Teste com italico_');
                    // $message->reply('**Teste com negrito**');
                    $message->reply($flirts[rand(0, count($flirts)-1)]['quote']);
                }
            });
        });
    }
}