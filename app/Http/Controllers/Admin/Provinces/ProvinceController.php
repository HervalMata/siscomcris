<?php

namespace App\Http\Controllers\Admin\Provinces;

use App\Http\Controllers\Controller;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use App\Shop\Provinces\Requests\UpdateProvinceRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProvinceController extends Controller
{
    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepository;

    /**
     * ProvinceController constructor.
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @param int $countryId
     * @param int $provinceId
     * @return Factory|View
     */
    public function show(int $countryId, int $provinceId)
    {
        $province = $this->provinceRepository->findProvinceById($provinceId);
        $cities = $this->provinceRepository->listCities($province);

        return view( 'admin.provinces.show', [
            'province' => $province,
            'countryid' => $countryId,
            'cities' => $this->provinceRepository->paginateArrayResults(collect($cities)->toArray())
        ]);
    }

    /**
     * @param int $countryId
     * @param int $provinceId
     * @return Factory|View
     */
    public function edit(int $countryId, int $provinceId)
    {
        return view('admin.provinces.edit', [
            'province' => $this->provinceRepository->findProvinceById($provinceId),
            'countryId' => $countryId
        ]);
    }

    /**
     * @param UpdateProvinceRequest $request
     * @param int $countryId
     * @param int $provinceId
     * @return RedirectResponse
     */
    public function update(UpdateProvinceRequest $request, int $countryId, int $provinceId)
    {
        $province = $this->provinceRepository->findProvinceById($provinceId);
        $update = new ProvinceRepository($province);
        $update->updateProvince($request->except('_method', '_token'));

        $request->session()->flash('message', 'Estado atualizado com sucesso.');
        return redirect()->route('countries.provinces.edit', [$provinceId, $countryId]);

    }
}
