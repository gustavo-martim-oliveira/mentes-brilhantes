<?php

/**
 *
 * Api update user
 * Format:
 * {
 *  data : {
 *      email : string,
 *      password : string,
 *      name: string
 *
 *      //You can change the address too (optional) by array or id
 *      address:
 *      {
 *          cep : integer,
 *          street : string,
 *          number : string,
 *          complement ?: nullable|string (optional)
 *          hood: string
 *      } ?: address_id
 *
 *      //You can change the state too (optional) by array or id
 *      state:
 *      {
 *          uf : integer (max:2) ,
 *          state : string,
 *      } ?: state_id
 *
 *      //You can change the city too (optional) by array or id
 *      state:
 *      {
 *          city : string,
 *          state_id : integer,
 *      } ?: city_id
 *
 *  }
 * }
 *
 */

namespace Controllers\Api\User;

use Config\Request;
use Config\Response;
use Models\Api\City;
use Models\Api\User;
use Config\Validator;
use Models\Api\State;
use Models\Api\Address;

class Update 
{

    protected $validationErrors = false;
    protected $user;

    public function update($user_id){

        $request = new Request;
        $data = [];
        $data = json_decode($request::get('data'), true);
        if(!is_array($data)){
            return Response::json(['error' => 'malformed json'], 500);
        }

        $data = array_merge($data);

        if(!$user_id){
            return response()->json(['error' => 'the user id is required!'], 404);
        }

        $user = new User;
        $hasUser = $user->where('id', '=', $user_id)->get();

        if(count($hasUser) <= 0){
            return Response::json(['error' => 'user not found!'], 404);
        }

        $this->user = $hasUser[0];

        if($request::has('address')){
            $address = $request::get('address');
            if(is_string($address)){
                $address = json_decode($request::get('address'), true);
            }
            
            $address = $this->syncAddress($address);
            $data = array_merge($data, [
                'address_id' => $address
            ]);
            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        if($request::has('state')){
            $state = $request::get('state');
            if(is_string($state)){
                $state = json_decode($request::get('state'), true);
            }
            
            $state = $this->syncState($state);
            $data = array_merge($data, [
                'state_id' => $state
            ]);
            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        if($request::has('city')){
            $city = $request::get('city');
            if(is_string($city)){
                $city = json_decode($request::get('city'), true);
            }
            
            $city = $this->syncCity($city, $data['state_id']);
            $request = array_merge($city, [
                'city_id' => $city
            ]);

            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        unset($data['address']);
        unset($data['state']);
        unset($data['city']);
        //Updated the data
        return Response::json($this->updateUser($data));

    }

    public function updateUser($data){
        $bdUser = new User;
        $update = $bdUser->update($this->user->id, $data);
        return $update;
    }

   /**
     * Sync Address
     *
     * @param integer|array $address
     * @return void
     */
    protected function syncAddress(int|array $address){

        if(is_array($address)){
            return $this->findOrCreateAddress($address);
        }

        $bdAddress = new Address;
        $address = $bdAddress->where('id', '=', $address)->get();

        if(count($address) <= 0 ){
            return Response::json(['error' => 'Address id not found!'], 404);
        }
        $address = $address[0]->id;

        return $address;

    }
    protected function findOrCreateAddress($address){

        if(!$this->validateAddress($address)){
            return response()->json($this->validationErrors);
        };

        $bdAddress = new Address;
        $getAddress = $bdAddress->where('number', '=', $address['number'])
                                ->where('street', '=', $address['street'])
                                ->where('hood', '=', $address['hood'])
                                ->where('complement', '=', $address['complement'] ?? null)
                                ->where('cep', '=', $address['cep'])
                                ->get();
        if(count($getAddress) == 1){
            $address = $getAddress[0]->id;
        }else{
            $newAddress = $bdAddress->create($address);
            $address = $bdAddress->where('id', '=', $newAddress)->get()[0]->id;

            $bdAddress->where('id', '=', $this->user->address_id)->delete();
        }

        return $address;
    }
    protected function validateAddress($address){
        $validator = new Validator;
        
        $validate = $validator->validate($address, [
            'cep' => 'required|integer',
            'street' => 'required',
            'number' => 'required',
            'hood' => 'required'
        ]);

        if($validate->fails()){
            $this->validationErrors = ['error' => $validate->getErrors()[0]];
            return false;
        }

        return true;

    }

    /**
     * Sync State
     *
     * @param integer|array $state
     * @return void
     */
    protected function syncState(int|array $state){
        if(is_array($state)){
            return $this->findOrCreateState($state);
        }

        $bdState = new State;
        $state = $bdState->where('id', '=', $state)->get();
        if(count($state) <= 0){
            return Response::json(['error' => 'State id not found!'], 404);
        }
        $state = $state[0]->id;
        return $state;
    }
    protected function findOrCreateState($state){

        if(!$this->validateState($state)){
            return response()->json($this->validationErrors);
        };

        $bdState = new State;
        $getStates = $bdState->where('uf', '=', $state['uf'])
                        ->where('state', '=', $state['state'])
                        ->get();
        if(count($getStates) == 1){
            $state = $getStates[0]->id;
        }else{
            $newState = $bdState->create($state);
            $state = $bdState->where('id', '=', $newState)->get()[0]->id;
        }

        return $state;
    }
    protected function validateState($state){
        $validate = new Validator;
        $validate = $validate->validate($state, [
            'uf'    => 'required|max:2',
            'state' => 'required'
        ]);

        if($validate->fails()){
            $this->validationErrors = ['error' => $validate->getErrors()[0]];
            return false;
        }

        return true;

    }

    /**
     * Sync City
     *
     * @param integer|array $city
     * @param integer|null $state
     * @return void
     */
    protected function syncCity(int|array $city, int $state){

        if(is_array($city) && is_numeric($state)){
            $city['state_id'] = $state;
        }

        if(is_array($city)){
            return $this->findOrCreateCity($city);
        }

        $bdCity = new City;
        $city = $bdCity->where('id', '=', $city)->get();
        if(count($city) <= 0){
            return Response::json(['error' => 'City id not found!'], 404);
        }

        return $city[0]->id;
    }
    protected function findOrCreateCity($city){

        if(!$this->validateCity($city)){
            return response()->json($this->validationErrors);
        };

        $bdCity = new City;
        $getCities = $bdCity->where('city', '=', $city['city'])
                        ->where('state_id', '=', $city['state_id'])
                        ->get();
        if(count($getCities) == 1){
            $city = $getCities[0]->id;
        }else{
            $newCity = $bdCity->create($city);
            $city = $bdCity->where('id', '=', $newCity)->get()[0]->id;
        }

        return $city;

    }
    protected function validateCity($city){
        $validate = new Validator;
        $validate = $validate->validate($city, [
            'city'     => 'required',
            'state_id' => 'required|integer'
        ]);

        if($validate->fails()){
            $this->validationErrors = ['error' => $validate->getErrors()[0]];
            return false;
        }

        return true;

    }
}
