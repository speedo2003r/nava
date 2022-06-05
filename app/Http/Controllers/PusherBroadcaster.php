<?php
namespace App\Http\Controllers;


use Illuminate\Broadcasting\Broadcasters\UsePusherChannelConventions;
use Pusher\Pusher;

class PusherBroadcaster
{
    use UsePusherChannelConventions;
    protected $pusher;

    /**
     * Create a new broadcaster instance.
     *
     * @param  \Pusher\Pusher  $pusher
     * @return void
     */
    public function __construct(Pusher $pusher)
    {
        $this->pusher = $pusher;
    }
    public function validAuthenticationResponse($request, $result)
    {
        if (str_starts_with($request->channel_name, 'private')) {
            return $this->decodePusherResponse(
                $request, $this->pusher->socket_auth($request->channel_name, $request->socket_id)
            );
        }

        $channelName = $this->normalizeChannelName($request->channel_name);

        $user = $this->retrieveUser($request, $channelName);

        $broadcastIdentifier = method_exists($user, 'getAuthIdentifierForBroadcasting')
            ? $user->getAuthIdentifierForBroadcasting()
            : $user->getAuthIdentifier();

        return $this->decodePusherResponse(
            $request,
            $this->pusher->presence_auth(
                $request->channel_name, $request->socket_id,
                $broadcastIdentifier, $result
            )
        );
    }

    /**
     * Decode the given Pusher response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $response
     * @return array
     */
    protected function decodePusherResponse($request, $response)
    {
        $appKey = env('PUSHER_APP_KEY');
        if (! $request->input('callback', false)) {
            return (object)[
                'auth' =>str_replace($appKey.':','',json_decode($response)->auth)
            ];
        }

        return response()->json(json_decode($response, true))
            ->withCallback($request->callback);
    }

}
