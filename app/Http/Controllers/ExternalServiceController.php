<?php

namespace App\Http\Controllers;

use App\ExternalService;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class ExternalServiceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = ["services" => ExternalService::all()];
    return view('external-services.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $filePath = (public_path() . '/services.yml');
    $services = Yaml::parse(file_get_contents($filePath));
    return view("external-services.create", ["services" => $services]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate(["name" => "required", "password" => "required"]);
    $data = [
      "service_name" => $request->name,
      "username" => $request->username,
      "email" => $request->email,
      "password" => $request->password
    ];
    ExternalService::create($data);
    return redirect()->route("external-services.index")->withSuccess("New Credentials Added!");
  }

  /**
   * Display the specified resource.
   *
   * @param \App\ExternalService $externalService
   * @return \Illuminate\Http\Response
   */
  public function show(ExternalService $externalService)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\ExternalService $externalService
   * @return \Illuminate\Http\Response
   */
  public function edit(ExternalService $externalService)
  {
    $filePath = (public_path() . '/services.yml');
    $services = Yaml::parse(file_get_contents($filePath));
    return view("external-services.edit", ["service" => $externalService, "services" => $services]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\ExternalService $externalService
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ExternalService $externalService)
  {
    $data = [
      "service_name" => $request->name,
      "username" => $request->username,
      "email" => $request->email,
      "password" => $request->password
    ];
    $externalService->update($data);
    return redirect()->route("external-services.index")->withSuccess("Updated Credentials!");

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\ExternalService $externalService
   * @return \Illuminate\Http\Response
   */
  public function destroy(ExternalService $externalService)
  {
    $externalService->delete();
    return redirect()->route("external-services.index")->withSuccess("Deleted Credentials!");

  }
}
