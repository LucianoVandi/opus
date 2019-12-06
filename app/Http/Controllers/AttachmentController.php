<?php

namespace App\Http\Controllers;

use App\Models\Wiki;
use App\Models\Activity;
use App\Models\Attachment;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class AttachmentController
 *
 * @package App\Http\Controllers
 * @author  Luciano Vandi <vandi.luciano@gmail.com>
 */
class AttachmentController extends Controller
{
    /**
     * @var \App\Models\Wiki
     */
    private $wiki;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var \App\Models\Page
     */
    private $page;

    /**
     * @var \App\Models\Attachment
     */
    private $attachment;

    /**
     * AttachmentController constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wiki         $wiki
     * @param \App\Models\Space        $space
     * @param \App\Models\Tag          $tag
     */
    public function __construct(Request $request, Wiki $wiki, Page $page, Attachment $attachment)
    {
        $this->wiki = $wiki;
        $this->page = $page;
        $this->attachment = $attachment;
        $this->request = $request;
    }

    /**
     * Store a new Attachment
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        // $this->validate($this->request, Wiki::WIKI_RULES);
        switch ($this->request->attachableType){
            case 'wiki':
                $attachable = $this->wiki->find($this->request->attachableId);
                $teamSlug = $attachable->team->slug;
                $directory = $teamSlug .'/'. $attachable->slug;
            break;
            case 'page':
                $attachable = $this->page->find($this->request->attachableId); 
                $teamSlug = $attachable->wiki->team->slug;
                $directory = $teamSlug .'/'. $attachable->wiki->slug .'/'. $attachable->slug;
            break;
        }

        $files = $this->request->attachments;

        foreach($files as $file){
            $path = $directory .'/'. $file->getClientOriginalName();
            $disk = Storage::disk('s3');
            $disk->makeDirectory($directory); 
            $result = $disk->put($path, file_get_contents($file), "private");

            if(!$result){
                // error
            }

            $attachment = new Attachment([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mimetype' => $file->getClientMimeType(),
                'user_id' => \Auth::id()
            ]);
    
            $attachable->attachments()->save($attachment);
        }

        return response()->json([
            'attachment' => $attachment,
            'teamSlug' => $teamSlug
        ]);
    }

    /**
     * Delete an Attachment
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $attachment = $this->attachment->find($this->request->attachmentId);
        $deleted = false;

        if($attachment){
            Storage::disk('s3')->delete($attachment->path);
            $deleted = $attachment->delete();
        }

        return response()->json([
            'deleted' => $deleted,
        ], 200);
    }

    /**
     * Get a temporary URL for access privete files on S3
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getTemporaryUrl()
    {    
        if(!$this->request->path){
            return abort(404);
        }
        
        $tempUrl = Storage::disk('s3')
            ->temporaryUrl($this->request->path, \Carbon\Carbon::now()->addMinutes(5));
        
        return redirect()->away($tempUrl);
    }

    
}
