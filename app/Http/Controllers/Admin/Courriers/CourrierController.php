<?php

namespace App\Http\Controllers\Admin\Courriers;

use App\Http\Controllers\Controller;
use App\Shop\Courriers\Repositories\CourrierRepository;
use App\Shop\Courriers\Repositories\Interfaces\CourrierRepositoryInterface;
use App\Shop\Courriers\Requests\CreateCourrierRequest;
use App\Shop\Courriers\Requests\UpdateCourrierRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourrierController extends Controller
{
    /**
     * @var CourrierRepositoryInterface
     */
    private $courrierRepository;

    /**
     * CourrierController constructor.
     * @param CourrierRepositoryInterface $courrierRepository
     */
    public function __construct(CourrierRepositoryInterface $courrierRepository)
    {
        $this->courrierRepository = $courrierRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.courriers.list', ['courriers', $this->courrierRepository->listCourriers('name', 'asc')]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.courriers.create');
    }

    /**
     * @param CreateCourrierRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCourrierRequest $request)
    {
        $this->courrierRepository->createCourrier($request->all());
        $request->session()->flash('message', 'Moeda criada com sucesso.');
        return redirect()->route('courriers.index');
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('admin.courriers.edit', ['courriers' => $this->courrierRepository->findCourrierById($id)]);
    }

    /**
     * @param UpdateCourrierRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateCourrierRequest $request, $id)
    {
        $courrier = $this->courrierRepository->findCourrierById($id);
        $update = new CourrierRepository($courrier);
        $update->updateCourrier($request->all());
        $request->session()->flash('message', 'Moeda atualizada com sucesso.');
        return redirect()->route('courriers.edit', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->courrierRepository->delete($id);
        } catch (QueryException $e) {
            request()->session()->flash('message', 'Desculpe, nós não podemos remover esta moeda. Ela está sendo usada por alguma ordem');
            return redirect()->route('courriers.index');
        }
        request()->session()->flash('message', 'Moeda removida com sucesso.');
        return redirect()->route('courriers.index');
    }
}
