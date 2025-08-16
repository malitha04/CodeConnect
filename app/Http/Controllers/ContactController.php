<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show(): View
    {
        return view('contact');
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    /**
     * Show all contact messages (admin only)
     */
    public function index(): View
    {
        $contacts = Contact::latest()->paginate(15);
        
        $stats = [
            'total' => Contact::count(),
            'unread' => Contact::unread()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Show a specific contact message
     */
    public function showMessage(Contact $contact): View
    {
        // Mark as read if unread
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Reply to a contact message
     */
    public function reply(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $contact->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Contact $contact): RedirectResponse
    {
        $contact->update(['status' => 'read']);
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    /**
     * Delete a contact message
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
}
