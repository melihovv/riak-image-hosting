<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use Basho\Riak;
use Basho\Riak\Command;
use Basho\Riak\Node;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class ImagesController extends Controller
{
    /**
     * @var Riak
     */
    private $riak;

    /**
     * ImagesController constructor.
     * @throws \Basho\Riak\Exception
     */
    public function __construct()
    {
        $nodes = (new Node\Builder)
            ->buildLocalhost([env('RIAK_COORDINATOR_PORT'), env('RIAK_NODE1_PORT'), env('RIAK_NODE2_PORT')]);

        $this->riak = new Riak($nodes);
    }

    public function index()
    {
        return view('images.index');
    }

    public function store(ImageStoreRequest $request)
    {
        /** @var UploadedFile $image */
        $image = $request->image;

        $response = (new Command\Builder\StoreObject($this->riak))
            ->buildJsonObject([
                'name' => $image->getClientOriginalName(),
                'extension' => $image->getClientOriginalExtension(),
                'mime_type' => $image->getClientMimeType(),
                'content' => base64_encode(file_get_contents($image->getRealPath())),
                'size' => $image->getSize(),
            ])
            ->buildBucket('images')
            ->build()->execute();

        return redirect()
            ->route('images.index')
            ->with('success', 'Your image was successfully uploaded.')
            ->with('image_url', route('images.show', $response->getLocation()->getKey()));
    }

    public function show($image)
    {
        $response = (new Command\Builder\FetchObject($this->riak))
            ->atLocation(new Riak\Location($image, new Riak\Bucket('images')))
            ->withDecodeAsAssociative()
            ->build()
            ->execute();

        if ($response->isNotFound()) {
            return redirect()
                ->route('images.index')
                ->with('error', 'There is no image with such url.');
        } elseif ($response->isSuccess()) {
            $image = $response->getObject()->getData();
            $content = base64_decode($image['content']);

            return response()->stream(function () use ($content) {
                echo $content;
            }, 200, ['Content-Type' => $image['mime_type']]);
        } else {
            return redirect()
                ->route('images.index')
                ->with('error', 'There was an error.');
        }

    }
}
