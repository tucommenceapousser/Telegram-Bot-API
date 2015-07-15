<?php

require 'Exception.php';

class telegramBot
{
  const BASE_URL = 'https://api.telegram.org/bot';

  protected $token;

  public function __construct($token)
  {
    $this->token = $token;
    $this->baseURL = self::BASE_URL . $this->token . DIRECTORY_SEPARATOR;
  }

  /**
   * A simple method for testing your bot's auth token.
   * Returns basic information about the bot in form of a User object.
   *
   * @link https://core.telegram.org/bots/api#getme
   *
   * @return Array
   */
  public function getMe()
  {
    return $this->sendRequest('getMe', null);
  }


  /**
   * Use this method to receive incoming updates using long polling.
   *
   * @link https://core.telegram.org/bots/api#getupdates
   *
   * @param int $offset
   * @param int $limit
   * @param int $timeout
   *
   * @return Array
   */
  public function pollUpdates($offset, $timeout = null, $limit = null)
  {
    $params = compact('offset', 'limit', 'timeout');

    return $this->sendRequest('getUpdates', $params);
  }

  /**
   * Send text messages.
   *
   * @link https://core.telegram.org/bots/api#sendmessage
   *
   * @param int            $chat_id
   * @param string         $text
   * @param bool           $disable_web_page_preview
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendMessage($chat_id, $text, $disable_web_page_preview = false, $reply_to_message_id = null, $reply_markup = null)
  {
    $params = compact('chat_id', 'text', 'disable_web_page_preview', 'reply_to_message_id', 'reply_markup');

    return $this->sendRequest('sendMessage', $params);
  }

  /**
   * Forward messages of any kind.
   *
   * @link https://core.telegram.org/bots/api#forwardmessage
   *
   * @param int $chat_id
   * @param int $from_chat_id
   * @param int $message_id
   *
   * @return Array
   */
  public function forwardMessage($chat_id, $from_chat_id, $from_chat_id)
  {
    $params = compact('chat_id', 'from_chat_id', 'from_chat_id');

    return $this->sendRequest('forwardMessage', $params);
  }

  /**
   * Send Photos.
   *
   * @link https://core.telegram.org/bots/api#sendphoto
   *
   * @param int            $chat_id
   * @param string         $photo
   * @param string         $caption
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendPhoto($chat_id, $photo, $caption = null, $reply_to_message_id = null, $replyMarkup = null)
  {
    $data = compact('chat_id', 'photo', 'caption', 'reply_to_message_id', 'reply_markup');

    if (((!is_dir($photo)) && (filter_var($photo, FILTER_VALIDATE_URL) === FALSE)))
      return $this->sendRequest('sendPhoto', $data);

    return $this->uploadFile('sendPhoto', $data);
  }

  /**
   * Send Audio.
   *
   * @link https://core.telegram.org/bots/api#sendaudio
   *
   * @param int            $chat_id
   * @param string         $audio
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendAudio($chat_id, $audio, $reply_to_message_id = null, $replyMarkup = null)
  {
    $data = compact('chat_id', 'audio', 'reply_to_message_id', 'reply_markup');

    if (((!is_dir($audio)) && (filter_var($audio, FILTER_VALIDATE_URL) === FALSE)))
      return $this->sendRequest('sendAudio', $data);

    return $this->uploadFile('sendAudio', $data);
  }

  /**
   * Send Document.
   *
   * @link https://core.telegram.org/bots/api#senddocument
   *
   * @param int            $chat_id
   * @param string         $document
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendDocument($chat_id, $document, $reply_to_message_id = null, $replyMarkup = null)
  {
    $data = compact('chat_id', 'document', 'reply_to_message_id', 'reply_markup');

    if (((!is_dir($document)) && (filter_var($document, FILTER_VALIDATE_URL) === FALSE)))
      return $this->sendRequest('sendDocument', $data);

    return $this->uploadFile('sendDocument', $data);
  }

  /**
   * Send Sticker.
   *
   * @link https://core.telegram.org/bots/api#sendsticker
   *
   * @param int            $chat_id
   * @param string         $sticker
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendSticker($chat_id, $sticker, $reply_to_message_id = null, $replyMarkup = null)
  {
    $data = compact('chat_id', 'sticker', 'reply_to_message_id', 'reply_markup');

    if (((!is_dir($sticker)) && (filter_var($sticker, FILTER_VALIDATE_URL) === FALSE)))
      return $this->sendRequest('sendSticker', $data);

    return $this->uploadFile('sendSticker', $data);
  }

  /**
   * Send Video.
   *
   * @link https://core.telegram.org/bots/api#sendvideo
   *
   * @param int            $chat_id
   * @param string         $video
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendVideo($chat_id, $video, $reply_to_message_id = null, $replyMarkup = null)
  {
    $data = compact('chat_id', 'video', 'reply_to_message_id', 'reply_markup');

    if (((!is_dir($video)) && (filter_var($video, FILTER_VALIDATE_URL) === FALSE)))
      return $this->sendRequest('sendVideo', $data);

    return $this->uploadFile('sendVideo', $data);
  }

  /**
   * Send Location.
   *
   * @link https://core.telegram.org/bots/api#sendlocation
   *
   * @param int            $chat_id
   * @param float          $latitude
   * @param float          $longitude
   * @param int            $reply_to_message_id
   * @param KeyboardMarkup $reply_markup
   *
   * @return Array
   */
  public function sendLocation($chat_id, $latitude, $longitude, $reply_to_message_id = null, $reply_markup = null)
  {
    $params = compact('chat_id', 'latitude', 'longitude', 'reply_to_message_id', 'reply_markup');

    return $this->sendRequest('sendLocation', $params);
  }

  /**
   * Send Chat Action.
   *
   * @link https://core.telegram.org/bots/api#sendchataction
   *
   * @param int            $chat_id
   * @param string         $action
   *
   * @return Array
   */
  public function sendChatAction($chat_id, $action)
  {
    $actions = array(
    'typing',
    'upload_photo',
    'record_video',
    'upload_video',
    'record_audio',
    'upload_audio',
    'upload_document',
    'find_location',
    );
    if (isset($action) && in_array($action, $actions))
    {
      $params = compact('chat_id', 'action');
      return $this->sendRequest('sendChatAction', $params);
    }

    throw new TelegramException('Invalid Action! Accepted value: '.implode(', ', $actions));
  }

  /**
   * Get user profile photos.
   *
   * @link https://core.telegram.org/bots/api#getsserprofilephotos
   *
   * @param int            $chat_id
   * @param int            $offset
   * @param int            $limit
   *
   * @return Array
   */
  public function getUserProfilePhotos($user_id, $offset = null, $limit = null)
  {
        $param = compact('user_id', 'offset', 'limit');

        return $this->sendRequest('getUserProfilePhotos', $params);
  }

 /**
  * Set a Webhook to receive incoming updates via an outgoing webhook.
  *
  * @param string $url HTTPS url to send updates to.
  *
  * @return Array
  *
  */
 public function setWebhook($url)
 {
   if (filter_var($url, FILTER_VALIDATE_URL) === false)
     throw new TelegramException('Invalid URL provided');

   if (parse_url($url, PHP_URL_SCHEME) !== 'https')
      throw new TelegramException('Invalid URL, it should be a HTTPS url.');

   return $this->sendRequest('setWebhook', $url);
}

 /**
  * Returns webhook updates sent by Telegram.
  * Works only if you set a webhook.
  *
  * @see setWebhook
  *
  * @return Array
  */
 public function getWebhookUpdates()
 {
   $body = json_decode(file_get_contents('php://input'), true);

   return $body;
 }

 /**
  * Removes the outgoing webhook.
  *
  * @return Array
  */
 public function removeWebhook()
 {
   $url = '';
   return $this->sendRequest('setWebhook', compact('url'));
 }

  private function sendRequest($method, $params)
  {
    if ($method == 'getMe')
      return json_decode(file_get_contents($this->baseURL . $method), true);

    return json_decode(file_get_contents($this->baseURL . $method . '?' . http_build_query($params)), true);
  }

  private function uploadFile($method, $data)
  {
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . mt_rand(0, 9999);
    if (filter_var($data['photo'], FILTER_VALIDATE_URL))
    {
      $url = true;
      file_put_contents($file, file_get_contents($data['photo']));
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($finfo, $file);

      $extensions = array(
        'image/jpeg'  => '.jpg',
        'image/png'   =>  '.png',
        'image/gif'   =>  '.gif',
        'image/bmp'   =>  '.bmp',
        'image/tiff'  =>  '.tif',
      );

      if (!in_array($ext, $extensions))
        throw new TelegramException('Bad file type/extension');
        
      $newFile = $file . $ext[$mime_type];
      rename($file, $newFile);
      $data['photo'] = new CurlFile($newFile, $mime_type, $newFile);
    }
    else
    {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($finfo, $data['photo']);
      $data['photo'] = new CurlFile($data['photo'], $mime_type, $data['photo']);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->baseURL . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = json_decode(curl_exec($ch), true);

    if ($url)
      unlink($newFile);

    return $response;
  }

}