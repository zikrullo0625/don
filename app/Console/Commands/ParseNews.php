<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'News parsing and logging using Guzzle and Symfony DOM Crawler';

    /**
     * Telegram Bot Token.
     *
     * @var string
     */
    protected $telegramBotToken = '7296354081:AAFMmqojjLISE3FA6c4jcmofNc6Fl_nDZN4';

    /**
     * Telegram Channel ID.
     *
     * @var string
     */
    protected $telegramChannelId = '-1002445745323';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = 'https://lenta.ru/';
        $response = $client->get($url);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        $newsItems = $crawler->filter('a.card-big._topnews._news');

        if ($newsItems->count() === 0) {
            $this->error('Новостные блоки не найдены');
            return;
        }

        $newsData = [];

        $newsItems->each(function (Crawler $node) use ($url, &$newsData) {
            try {
                // Получаем заголовок новости
                $titleNode = $node->filter('.card-big__title');
                if ($titleNode->count() === 0) {
                    throw new \Exception('Заголовок не найден');
                }
                $title = $titleNode->text();

                // Получаем ссылку на новость
                $link = 'https://lenta.ru' . $node->attr('href');
                $this->sendToTelegram($link);

                // Сохраняем данные в массив
                $newsData[] = [
                    'title' => $title,
                    'link' => $link,
                    'source' => $url, // Исходный адрес сайта
                ];

                // Выводим ссылку в консоль
                $this->info("Заголовок: $title");
                $this->info("Ссылка: $link");
                $this->info("Источник: $url");
                $this->info(str_repeat('=', 50)); // Разделитель для удобства чтения

            } catch (\Exception $e) {
                $this->error('Ошибка: ' . $e->getMessage());
            }
        });
    }

    /**
     * Отправка сообщения в Telegram.
     *
     * @param string $message
     */
    protected function sendToTelegram(string $message)
    {
        $client = new Client();
        $url = "https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage";

        try {
            $client->post($url, [
                'json' => [
                    'chat_id' => $this->telegramChannelId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ],
            ]);
        } catch (\Exception $e) {
            $this->error('Не удалось отправить сообщение в Telegram: ' . $e->getMessage());
        }
    }
}
