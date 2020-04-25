<?php

namespace App\Http\Controllers\Admin\Cities;

use App\Http\Controllers\Controller;
use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Cities\Requests\UpdateCityRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CityController extends Controller
{
    /**
     * @var CityRepositoryInterface
     */
    private $cityRepository;

    /**
     * CityController constructor.
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param int $countryId
     * @param int $provinceId
     * @param int $cityId
     * @return Factory|View
     */
    public function edit(int $countryId, int $provinceId, int $cityId)
    {
        $city = $this->cityRepository->findCityById($cityId);

        return view('admin.cities.edit', [
            'city' => $city,
            'countryId' => $countryId,
            'provinceId' => $provinceId
        ]);
    }

    /**
     * @param UpdateCityRequest $request
     * @param int $countryId
     * @param int $provinceId
     * @param int $cityId
     * @return RedirectResponse
     */
    public function update(UpdateCityRequest $request, int $countryId, int $provinceId, int $cityId)
    {
        $city = $this->cityRepository->findCityById($cityId);
        $update = new CityRepository($city);
        $update->updateCity($request->except('_method', '_token'));

        $request->session()->flash('message', 'Cidade atualizada com sucesso.');
        return redirect()->route('countries.provinces.cities.edit', [$provinceId, $countryId, $cityId]);

    }
}
