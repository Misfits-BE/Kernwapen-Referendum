<?php 

namespace App\Repositories;

use App\City;
use Illuminate\Notifications\DatabaseNotification;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Notifications\SpeakRightNotification;
use App\User;
use Illuminate\Pagination\Paginator;

/**
 * Class NotificationRepository
 *
 * @package App\Repositories
 */
class NotificationRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return DatabaseNotification::class;
    }

    /**
     * Zend een notificatie omtrent spreekrecht naar de administrators van de applicatie. 
     * 
     * @param  int $postal De postcode van de gegeven stad.  
     * @return void 
     */
    public function sendSpeakRightNotification($postal): void
    {
        try { // To find the city and notify the system admins.
            $city  = City::where('postal', $postal)->firstOrFail();   
            $users = User::all();

            foreach ($users as $user) {
                if ($user->hasRole('admin')) {
                    $when = now()->addMinute();
                    $user->notify((new SpeakRightNotification($city))->delay($when));
                } 
            } 
        }

        // Lege exception omdat er geen output nodig is 
        // Wanneer er geen stad word gevonden onder de gegeven postcode
        catch (ModelNotFoundException $exception) { }
    }

    /**
     * Haal de notificaties voor de aangemelde gebruiker op in de database
     * 
     * @param  string $type     Het type van de paginatie view instantie
     * @param  int    $perPage  Het aantal notificaties dat men per pagina wilt weergeven
     * @return \Illuminate\Pagination\Paginator
     */
    public function getUserNotifications(string $type, int $perPage): Paginator 
    {
        $notifications = auth()->user()->unreadNotifications(); 

        switch ($type) {
            case 'simple':   return $notifications->simplePaginate($perPage);
            case 'default':  return $notifications->paginate($perPage); 
            
            default: return $notifications->paginate($perPage);
        }
    }

    public function markAllAsread(): ?bool
    {
        return auth()->user()->unreadNotifications->markAsRead();
    }
}