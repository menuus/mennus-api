<table class="table table-responsive-sm table-hover table-outline mb-0">
    <thead class="thead-light">
        <tr>
            <th class="text-center">
                <svg class="c-icon">
                    <use xlink:href="assets/icons/free-symbol-defs.svg#cui-people"></use>
                </svg>
            </th>
            <th>Cliente</th>
            <!-- <th>Tempo</th> -->
            <th>Pedidos</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td class="text-center">
                <div class="c-avatar">
                    @if($order->user->profile && $order->user->profile->image)
                    <img class="c-avatar-img" src="{{ $order->user->profile->image->path }}" alt={{ $order->user->email }}>
                    @else
                    <svg class="c-avatar-img" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 008 15a6.987 6.987 0 005.468-2.63z" />
                        <path fill-rule="evenodd" d="M8 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M8 1a7 7 0 100 14A7 7 0 008 1zM0 8a8 8 0 1116 0A8 8 0 010 8z" clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
            </td>

            <td>
                <div>{{ $order->user->name }}</div>
                <div class=" small text-muted">{{ $order->user->email }}</div>
            </td>

            <!-- <td></td> -->

            <td>
                @foreach($order->plates as $plate)
                <strong>{{$plate->pivot->plates_amount}}x: </strong>{{ $plate->name }}<br />
                @endforeach
            </td>

            <td class="text-center">
                <button class="btn btn-primary" type="button" onclick="callOrder({{ $order->id }})">
                    <svg class="c-icon" title="Chamar">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-phone"></use>
                    </svg>
                </button>

                <button class="btn btn-warning" type="button" onclick="orderSelected={{ $order->id }};" data-toggle="modal" data-target="#confirmationModal">
                    <svg class="c-icon" title="Cancelar pedido">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-trash"></use>
                    </svg>
                </button>

                <button class="btn btn-success" type="button" onclick="closeOrder({{ $order->id }})">
                    <svg class="c-icon" title="Finalizar pedido">
                        <use xlink:href="assets/icons/free-symbol-defs.svg#cui-check"></use>
                    </svg>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td class="text-center" colspan="4">Sem pedidos</td>
        </tr>
        @endforelse

        <!-- <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/1.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                                        </td>
                                        <td>
                                            <div>Yiorgos Avraamu</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>50%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>10 sec ago</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/2.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                                        </td>
                                        <td>
                                            <div>Avram Tarasios</div>
                                            <div class="small text-muted"><span>Recurring</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>10%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>5 minutes ago</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/3.jpg" alt="user@email.com"><span class="c-avatar-status bg-warning"></span></div>
                                        </td>
                                        <td>
                                            <div>Quintin Ed</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>74%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>1 hour ago</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/4.jpg" alt="user@email.com"><span class="c-avatar-status bg-secondary"></span></div>
                                        </td>
                                        <td>
                                            <div>Enéas Kwadwo</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>98%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>Last month</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/5.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                                        </td>
                                        <td>
                                            <div>Agapetus Tadeáš</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>22%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>Last week</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/6.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                                        </td>
                                        <td>
                                            <div>Friderik Dávid</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>43%</strong></div>
                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">Last login</div><strong>Yesterday</strong>
                                        </td>
                                    </tr> -->
    </tbody>
</table>