<?php

class Instagram {

    /*
     * @var
     * @access private
     * @description declare the URL for instagram cURL
     */
    private $url = null;

    /*
     * @function constructor
     * @parameters $client_id, $tag
     * @return void
     */
    public function __construct( $client_id, $tag  ){
        $this->url = 'https://api.instagram.com/v1/tags/' . $tag . '/media/recent?client_id=' . $client_id;
    }


    /*
     * @function getPhotos
     * @parameters $start_date => default: '0000-00-00'
     * @return json with array of photos
     */
    public function getPhotos( $start_date = '0000-00-00' )
    {
        //convert start_date to timestamp
        $start_ts = strtotime( $start_date );

        //curl to get instagram data
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        //end of curl

        //decode return of curl
        $results = json_decode($result, true);

        $itens = array();
        foreach($results['data'] as $item){
            if ( $item['type'] == 'image' &&
                $item['created_time'] >= $start_ts )
            {
                $itens[] = array(
                                    'id' => $item['id'],
                                    'time' => $item['created_time'],
                                    'name' => $item['user']['full_name'],
                                    'user_photo' => $item['user']['profile_picture'],
                                    'photo' => $item['images']['standard_resolution']['url'],
                                    'likes' => count( $item['likes'] ),
                                    'hashtags' => $item['tags'],
                                    'all_parameters' => $item
                                );
            }
        }
        return json_encode( $itens );
    }
}

?>
