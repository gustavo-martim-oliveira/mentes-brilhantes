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

namespace App\Http\Controllers\Api\User;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Update extends Controller
{

    protected $validationErrors = false;
    protected $user;

    public function update(Request $request, $user_id){

        $data = json_decode($request->data, true);
        if(!is_array($data)){
            return response()->json(['error' => 'malformed json'], 500);
        }

        $request = $request->merge([
            'data' => $data,
        ]);

        if(!$user_id){
            return response()->json(['error' => 'the user id is required!'], 404);
        }

        $this->user = User::where('id', $user_id)->first();

        if(!$this->user){
            return response()->json(['error' => 'user not found!'], 404);
        }

        if($request->has('address')){
            $address = json_decode($request->address, true);
            $address = $this->syncAddress($address);
            $request = $request->merge([
                'address_id' => $address
            ]);
            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        if($request->has('state')){
            $state = json_decode($request->state, true);
            $state = $this->syncState($state);
            $request = $request->merge([
                'state_id' => $state
            ]);
            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        if($request->has('city')){
            $city = json_decode($request->city, true);
            $city = $this->syncCity($city, (is_numeric($state) ? $state : null));
            $request = $request->merge([
                'city_id' => $city
            ]);

            if($this->validationErrors){
                return response()->json($this->validationErrors);
            }
        }

        //Updated the data
        $this->user->update($data);
        return $this->user;

    }

    /**
     * Sync Address
     *
     * @param integer|array $address
     * @return void
     */
    protected function syncAddress(int|array $address){

        if(is_object($address) || is_array($address)){
            return $this->findOrCreateAddress($address);
        }

        $address = Address::where('id', $address)->first();
        if(!$address){
            return response()->json(['error' => 'Address id not found!'], 404);
        }

        return $address->id;

    }
    protected function findOrCreateAddress($address){

        if(!$this->validateAddress($address)){
            return response()->json($this->validationErrors);
        };

        $address = Address::firstOrCreate([
            'number'        => $address['number'],
            'street'        => $address['street'],
            'hood'          => $address['hood'],
            'complement'    => $address['complement'] ?? '',
            'cep'           => $address['cep']
        ], $address );

        $oldAddress = Address::where('id', $this->user->address_id)->first();
        if($oldAddress){
            $oldAddress->delete();
        }

        return $address->id;
    }
    protected function validateAddress($address){
        $validate = Validator::make($address, [
            'cep' => 'required|integer',
            'street' => 'required',
            'number' => 'required',
            'hood' => 'required'
        ]);

        if(!$validate->passes()){
            $this->validationErrors = ['error' => $validate->errors()->first()];
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
        if(is_object($state) || is_array($state)){
            return $this->findOrCreateState($state);
        }

        $state = State::where('id', $state)->first();
        if(!$state){
            return response()->json(['error' => 'State id not found!'], 404);
        }

        return $state->id;
    }
    protected function findOrCreateState($state){

        if(!$this->validateState($state)){
            return response()->json($this->validationErrors);
        };

        $state = State::firstOrCreate([
            'uf'    => $state['uf'],
            'state' => $state['state']
        ], $state );

        return $state->id;
    }
    protected function validateState($state){

        $validate = Validator::make($state, [
            'uf'    => 'required|max:2',
            'state' => 'required'
        ]);

        if(!$validate->passes()){
            $this->validationErrors = ['error' => $validate->errors()->first()];
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
    protected function syncCity(int|array $city, int $state = null){

        if($state) $city['state_id'] = $state;

        if(is_object($city) || is_array($city)){
            return $this->findOrCreateCity($city);
        }

        $city = City::where('id', $city)->first();
        if(!$city){
            return response()->json(['error' => 'City id not found!'], 404);
        }

        return $city->id;
    }
    protected function findOrCreateCity($city){

        if(!$this->validateCity($city)){
            return response()->json($this->validationErrors);
        };

        $city = City::firstOrCreate([
            'city'     => $city['city'],
            'state_id' => $city['state_id']
        ], $city );

        return $city->id;
    }
    protected function validateCity($city){
        $validate = Validator::make($city, [
            'city'     => 'required',
            'state_id' => 'required|integer'
        ]);

        if(!$validate->passes()){
            $this->validationErrors = ['error' => $validate->errors()->first()];
            return false;
        }

        return true;

    }
}
