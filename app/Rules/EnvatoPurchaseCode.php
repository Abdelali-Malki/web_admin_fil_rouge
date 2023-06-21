<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;


class EnvatoPurchaseCode implements Rule

{

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct()

    {

    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)

    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://wall71.coder71.com/verify-purchase/'.$value,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response);

        if(@$res->status=='success'){
            return true;
        }
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */

    public function message()

    {
        return 'Invalid purchase code';
    }

}