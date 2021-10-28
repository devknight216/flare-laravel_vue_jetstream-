<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProviderUpdateApplicationResult extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->application->status == "rejected") {
            return (new MailMessage)
                ->subject('You\'re application result.')
                ->line("We have carefully reviewed your application to update your provider listing and have REJECTED it at this time. Please see below for comments.")
                ->line('Comment: ' . $this->application->admin_notes)
                ->line('Please resubmit your application with the required changes.')
                ->line('Thank you for your understanding.');
        }
        return (new MailMessage)
            ->subject('You\'ve application result.')
            ->line("Hi there, we have carefully reviewed your application to update your provider listing and have APPROVED the changes. Please see below for comments.")
            ->line('Comment: ' . $this->application->admin_notes)
            ->line('Thank you for updating your listing!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}