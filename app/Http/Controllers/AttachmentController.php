<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Wiki;
use App\Models\Space;
use App\Models\Attachment;
use App\Models\Activity;
use Illuminate\Http\Request;

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
        $file = $this->request->file('attachment');
        $disk = \Storage::disk('s3');
        $result = $disk->put(urlencode($file->getClientOriginalName()), $file, "private");
        dd($result);
        // originalName: 
        // mimeType: "image/jpeg"
        // $this->validate($this->request, Wiki::WIKI_RULES);

        return redirect()->route('wikis.show', [$team->slug, $wiki->space->slug, $wiki->slug])->with([
            'alert'      => _i('Wiki successfully created.'),
            'alert_type' => 'success',
        ]);
    }

    
}
