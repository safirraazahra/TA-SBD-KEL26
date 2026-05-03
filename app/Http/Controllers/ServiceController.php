<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('q');
        $category = $request->input('category');

        $services = Service::where('seller_id', Auth::id())
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->latest()
            ->paginate(10);

        return view('seller.services.index', compact('services', 'search', 'category'));
    }

    public function create()
    {
        return view('seller.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string'],
            'category'        => ['required', 'in:print_hitam_putih,print_berwarna,fotocopy,jilid,laminating,scan,banner,lainnya'],
            'price_per_unit'  => ['required', 'numeric', 'min:0'],
            'unit'            => ['required', 'string', 'max:50'],
            'min_order'       => ['required', 'integer', 'min:1'],
            'turnaround_days' => ['required', 'integer', 'min:1'],
            'image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->except('image');
        $data['seller_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('seller.services')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        if ($service->seller_id !== Auth::id()) abort(403);
        return view('seller.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if ($service->seller_id !== Auth::id()) abort(403);

        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string'],
            'category'        => ['required', 'in:print_hitam_putih,print_berwarna,fotocopy,jilid,laminating,scan,banner,lainnya'],
            'price_per_unit'  => ['required', 'numeric', 'min:0'],
            'unit'            => ['required', 'string', 'max:50'],
            'min_order'       => ['required', 'integer', 'min:1'],
            'turnaround_days' => ['required', 'integer', 'min:1'],
            'image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active'       => ['nullable', 'boolean'],
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('seller.services')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if ($service->seller_id !== Auth::id()) abort(403);
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete(); // hard delete
        return redirect()->route('seller.services')->with('success', 'Layanan berhasil dihapus.');
    }

    public function toggleActive(Service $service)
    {
        if ($service->seller_id !== Auth::id()) abort(403);
        $service->update(['is_active' => !$service->is_active]);
        $msg = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Layanan berhasil $msg.");
    }
}
