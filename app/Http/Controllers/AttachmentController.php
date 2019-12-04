<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Wiki;
use App\Models\Space;
use App\Models\Activity;
use App\Models\Attachment;
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
     * @var \App\Models\Space
     */
    private $space;

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
    public function __construct(Request $request, Wiki $wiki, Space $space, Attachment $attachment)
    {
        $this->wiki      = $wiki;
        $this->space     = $space;
        $this->attachment = $attachment;
        $this->request   = $request;
    }

    /**
     * Create a new attachment.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Team $team, Space $space, Wiki $wiki)
    {
        // $this->validate($this->request, Wiki::WIKI_RULES);

        $file = $this->request->file('attachment');
        $path = $wiki->slug .'/'. urlencode($file->getClientOriginalName());

        $disk = Storage::disk('s3');
        $disk->makeDirectory($wiki->slug);
        
        $result = $disk->put($path, file_get_contents($file), "private");

        if(!$result){
            // error
        }

        $attachment = new Attachment([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mimetype' => $file->getClientMimeType()
        ]);

        $wiki->attachments()->save($attachment);

        return redirect()->route('wikis.show', [$team->slug, $wiki->space->slug, $wiki->slug])->with([
            'alert'      => _i('Wiki successfully created.'),
            'alert_type' => 'success',
        ]);
    }

    public function getTemporaryUrl(){
        
        if(!$this->request->path){
            return abort(404);
        }
        
        $tempUrl = Storage::disk('s3')
            ->temporaryUrl($this->request->path, \Carbon\Carbon::now()->addMinutes(5));
        
        return redirect()->away($tempUrl);
    }

    
}
