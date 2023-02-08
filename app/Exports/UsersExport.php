<?php
  
namespace App\Exports;
  
use App\Models\ChassisNumber;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Http;

  
class UsersExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     $new_list = [];
	// 	$chassis_numbers = ChassisNumber::select('CHASSIS')->limit(3)->get();
    //     // dd($chassis_numbers);
    //     // $chassis_numbers_array = (array) $chassis_numbers;
	// 	foreach ($chassis_numbers as $chassis_number) {
	// 		$response_data = [];
	// 		//sleep(240);
	// 		$response = Http::get('https://partsapi.ru/api.php?method=VINdecode&key=f1af8ee7f280a19d3bec7b44a8c64310&vin='.$chassis_number->CHASSIS.'&lang=en');
	// 		$chassis_number['VIN_Number'] = $chassis_number->CHASSIS;
	// 		$chassis_number['Data'] = !empty($response->body()) ? json_decode($response->body()) : NULL;
	// 		array_push($new_list, $chassis_number);
	// 	}

    //     // dd($new_list);
		
	// 		// array_unshift($new_list, array_keys($new_list[0]));
	// 		$collection = collect($new_list);
            
    //         // dd($collection);
    //         return $collection;
    // }


    public function headings(): array
    {
        return [
            'VIN_Number',
            'Data',
            'CHASSIS',
            
        ];
    }
    public function query()
    {
        $new_list = [];
		$chassis_numbers = ChassisNumber::select('CHASSIS')->limit(3)->get();
        // dd($chassis_numbers);
        // $chassis_numbers_array = (array) $chassis_numbers;
		foreach ($chassis_numbers as $chassis_number) {
			$response_data = [];
			//sleep(240);
			$response = Http::get('https://partsapi.ru/api.php?method=VINdecode&key=f1af8ee7f280a19d3bec7b44a8c64310&vin='.$chassis_number->CHASSIS.'&lang=en');
			$chassis_number['VIN_Number'] = $chassis_number->CHASSIS;
			$chassis_number['Data'] = !empty($response->body()) ? json_decode($response->body()) : NULL;
            
			// array_push($new_list, $chassis_number);
		}

        // dd($new_list);
		
			// array_unshift($new_list, array_keys($new_list[0]));
			// $collection = collect($new_list);
            
            // // dd($collection);
            // return $chassis_numbers;
    }
    public function map($bulk): array
    {
        
        return [
            $bulk->CHASSIS,
            $bulk->VIN_Number,
            $bulk->Data,
            
        ];
    }
}