<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CustomerAddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;
    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepository;

    /**
     * CustomerAddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    )
    {
        $this->addressRepository = $addressRepository;
        $this->countryRepository = $countryRepository;
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param int $customerId
     * @param int $addressId
     * @return Factory|View
     */
    public function show(int $customerId, int $addressId)
    {
        return view('admin.addresses.customers.show', [
            'address' => $this->addressRepository->findAddressById($addressId),
            'customerId' => $customerId
        ]);
    }

    /**
     * @param int $customerId
     * @param int $addressId
     * @return Factory|View
     */
    public function edit(int $customerId, int $addressId)
    {
        $ph = $this->countryRepository->findCountryById(169);
        $prov = $this->provinceRepository->findProvinceById(1);

        return view('admin.addresses.customers.edit', [
            'address' => $this->addressRepository->findAddressById($addressId),
            'countries' => $this->countryRepository->listCountries(),
            'provinces' => $this->countryRepository->findProvinces($ph),
            'cities' => $this->provinceRepository->listCities($prov),
            'customerId' => $customerId
        ]);
    }
}
