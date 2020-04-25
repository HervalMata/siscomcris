<?php

namespace App\Http\Controllers\Admin\Addresses;

use App\Http\Controllers\Controller;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;
    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepository;

    /**
     * AddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    )
    {
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
        $this->countryRepository = $countryRepository;
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $list = $this->addressRepository->ListAddresses('created_at', 'desc');

        return view('admin.addresses.list', ['addresses' => $this->addressRepository->paginateArrayResults($list, 10)]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $ph = $this->countryRepository->findCountryById(169);
        $prov = $this->provinceRepository->findProvinceById(1);
        $customers = $this->customerRepository->ListCustomers();
        return view('admin.addresses.create', [
            'customers' => $customers,
            'countries' => $this->countryRepository->ListCountries(),
            'provinces' => $this->countryRepository->findProvinces($ph),
            'cities' => $this->provinceRepository->listCities($prov)
        ]);
    }

    /**
     * @param CreateAddressRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAddressRequest $request)
    {
        $customer = $this->customerRepository->findCustomerById($request->input('customer_id'));
        $this->addressRepository->createAddress($request->except('customer', $customer));

        $request->session()->flash('message', 'Eedereço cadastrado com sucesso.');
        return redirect()->route('addresses.index');
    }

    /**
     * @param int $id
     * @return Factory|View
     */
    public function show(int $id)
    {
        return view('admin.addresses.show', [ 'address' => $this->addressRepository->findAddressById($id) ]);
    }

    /**
     * @param int $Id
     * @return Factory|View
     */
    public function edit(int $Id)
    {
        $address = $this->addressRepository->findAddressById($Id);
        $ph = $this->countryRepository->findCountryById($address->country->id);
        $prov = $this->provinceRepository->findProvinceById($address->province->id);
        $customer = $this->addressRepository->findCustomer($address);

        return view('admin.addresses.edit', [
            'address' => $address,
            'countries' => $this->countryRepository->ListCountries(),
            'countryId' => $address->country->id,
            'provinces' => $this->countryRepository->findProvinces($ph),
            'provinceId' => $address->province->id,
            'cities' => $this->provinceRepository->listCities($prov),
            'cityId' => $address->city->id,
            'customers' => $this->customerRepository->ListCustomers(),
            'customerId' => $customer->id
        ]);
    }

    /**
     * @param CreateAddressRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CreateAddressRequest $request, int $id)
    {
        $address = $this->addressRepository->findAddressById($id);
        $update = new AddressRepository($address);
        $update->updateAddress($request->except('_method', '_token'));

        $request->session()->flash('message', 'Endereço atualizado com sucesso.');
        return redirect()->route('addresses.edit', $id);

    }
}
