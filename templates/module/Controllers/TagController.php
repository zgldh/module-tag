<?php namespace WoXuanWang\Tag\Controllers;

use WoXuanWang\Tag\Requests\CreateTagRequest;
use WoXuanWang\Tag\Requests\UpdateTagRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ShowRequest;
use Illuminate\Http\JsonResponse;
use WoXuanWang\Tag\Repositories\TagRepository;
use zgldh\Scaffold\AppBaseController;

class TagController extends AppBaseController
{

    public function __construct(TagRepository $tagRepository)
    {
        $this->repository = $tagRepository;
        $this->middleware("auth", [
            'except' => ['mostUsed', 'index']
        ]);
    }

    /**
     * Display a listing of the Tag.
     *
     * @param Request $request
     * @return Response
     */
    public function index(IndexRequest $request)
    {
        $with = $request->getWith();
        $data = $this->repository->datatables(null, $with);
        return $data;
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     * @return JsonResponse
     */
    public function store(CreateTagRequest $request)
    {
        $input = $request->all();

        $tag = $this->repository->create($input);
        $tag->load($request->getWith());

        return $this->sendResponse($tag, 'Tag saved successfully.');
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function show($id, ShowRequest $request)
    {
        $tag = $this->repository->findWithoutFail($id);
        $tag->load($request->getWith());

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        return $this->sendResponse($tag, '');
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  int $id
     * @param UpdateTagRequest $request
     *
     * @return JsonResponse
     */
    public function update($id, UpdateTagRequest $request)
    {
        $tag = $this->repository->findWithoutFail($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $tag = $this->repository->update($request->all(), $id);
        $tag->load($request->getWith());

        return $this->sendResponse($tag, 'Tag updated successfully.');
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $tag = $this->repository->findWithoutFail($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $this->repository->delete($id);
        return $this->sendResponse($tag, 'Tag deleted successfully.');
    }

    public function mostUsed()
    {
        $tags = $this->repository->getMostUsedTags();
        return $this->sendResponse($tags, '');
    }
}
