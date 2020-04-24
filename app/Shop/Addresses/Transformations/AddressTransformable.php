<?php


namespace App\Shop\Customers\Repositories;


use App\Shop\Addresses\Address;
use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use App\Shop\Provinces\Province;

trait AddressTransformable
{
    public function transformAddress(Address $address)
    {
        $prop = new Address;
        $prop->id = $address->id;
        $prop->alias = $address->alias;
        $prop->address_1 = $address->address_1;
        $prop->address_2 = $address->address_2;
        $prop->zip = $address->zip;

        $cityRepository = new CityRepository(new City);
        $city = $cityRepository->findCityById($address->city_id);
        $prop->city = $city;

        $provinceRepository = new ProvinceRepository(new Province);
        $province = $provinceRepository->findCityById($address->province_id);
        $prop->province = $province;

        $countryRepository = new CountryRepository(new Country);
        $country = $countryRepository->findCityById($address->country_id);
        $prop->country = $country;

        $prop->customer_id = $address->customer_id;
        $prop->status = $address->status;

        return $prop;
    }
}
