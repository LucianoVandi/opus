<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Team;
use App\Models\Invite;
use Illuminate\Http\Request;

/**
 * Class InviteController
 *
 * @package App\Http\Controllers
 * @author  Zeeshan Ahmed <ziishaned@gmail.com>
 */
class InviteController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Models\Invite
     */
    protected $invite;

    /**
     * InviteController constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invite       $invite
     */
    public function __construct(Request $request, Invite $invite)
    {
        $this->request = $request;
        $this->invite  = $invite;
    }

    /**
     * {{_i('Invite user')}} to team.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Team $team)
    {
        $this->validate($this->request, Invite::INVITE_RULES, [
            'is_already_invited' => _i('A user with this email already invited.'),
            'is_already_member'  => _i('A user with this email already exists.'),
        ]);

        $invitation = $this->invite->inviteUser($this->request->all());

        $this->sendInvitationEmail($invitation, $team);

        return redirect()->back()->with([
            'alert'      => _i('Invitation is successfully sent to user.'),
            'alert_type' => 'success',
        ]);
    }

    /**
     * Send invitation mail to the invited user.
     *
     * @param $invitation
     * @param $team
     * @return bool
     */
    public function sendInvitationEmail($invitation, $team)
    {
        Mail::send('mails.invitation', ['invitation' => $invitation, 'team' => $team], function ($message) use ($invitation, $team) {
            $message->from(config('opus.mail_sender_address'), config('opus.mail_sender_name'));
            $message->subject(_i('Invitation request from ') . $team->name . '.');
            $message->to($invitation->email);
        });

        return true;
    }

    /**
     * Delete pending invitation.
     *
     * @param \App\Models\Team $team
     * @param                  $invitationCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Team $team, $invitationCode)
    {
        $this->invite->deleteInvitation($invitationCode, $team->id);

        return redirect()->back()->with([
            'alert'      => _i('Invitation successfully removed.'),
            'alert_type' => 'success',
        ]);
    }
}
