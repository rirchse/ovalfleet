<div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-{{$package->bg_color}}">
                  <div class="inner">
                    <h3>${{number_format($package->package_price, 0)}}</h3>
                    <h4>{{$package->package_name}}</h4>
                    <p>1 - {{$package->max_dispatcher}} dispatchers<br>Max {{$package->max_driver}} drivers</p>
                    @if($package->duration == 'year')
                    <h4 style="text-align:center;font-weight:bold">With 15% Discount</h4>
                    @endif
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats"></i>
                  </div>
                  <?php $notSubscribe = DB::table('subscriptions')->where('user_id', $user->id)->where('stripe_plan', $package->stripe_plan_id)->first(); ?>
                  @if($notSubscribe == null)
                    <a href="/get_package/{{$package->id}}" class="btn btn-{{$package->btn_color}} btn-block btn-lg"> {{!empty($mypackage) && $mypackage->package_id == $package->id?'Renew':'Get Started'}} <i class="fa fa-arrow-circle-right"></i></a>
                  @else
                    {{-- <h4 class="text-danger text-center">Current Service Plan</h4> --}}
                    <form action="{{ route('unsubscription') }}" method="post" >
                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input type="hidden" name="plan" value="{{ $package->id }}" />
                      <div class="card-footer">
                        <button class="btn btn-{{$package->btn_color}} btn-block btn-lg"> Un-Subscribe <i class="fa fa-arrow-circle-right"></i></button>
                      </div>
                    </form>
                  @endif
                </div>
              </div>