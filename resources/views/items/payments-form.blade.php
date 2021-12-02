<div class="card mb-3 mt-3" >
    <div class="card-header" id="enrollment-header">
        <h1>Payments</h1>
    </div>
    <div class="card-body">
        <div class="mb-1 mt-1">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="mb-3"><strong>Submit Proof of Payment</strong></h2>
                    <div class="row">
                        <div class="mb-3 form-group @error('payment') has-error @enderror">
                            {!! Form::label('payment','Payment Channel',[],false) !!}
                            {{Form::select('payment', [
                                1 => 'Palawan Pawnshop',
                                2 => 'GCash',
                            ], null, ['class'=>'form-control form-select', 'id'=>'modal-input-payment'])}}
                            <span class="errspan" id="errspan">{{ $errors->first('payment') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 form-group @error('amount') has-error @enderror">
                            {!! Form::label('amount', 'Amount Paid',[],false) !!}
                            {!! Form::number('amount', null, ['class'=>'form-control','required' => '', 'id'=>'modal-input-contact']) !!}
                            <span class="errspan" id="errspan">{{ $errors->first('amount') }}</span>  
                        </div>
                    </div>
                    <div class="uploadPhoto">
                        <input class="photo" type="file" id="image-select" accept="image/*">
                    </div>
                    <div class="submitted-docu mt-4">
                        <h5>Payment Submitted:</h5>
                    </div>
                </div>

                <div class="col-md-7 ml-5">
                    <h4>Available Payment Channel</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="{{asset('img/palawan.jpg')}}" class="card-img-top" style="height:230px;">
                                <div class="card-body">
                                    <h3 class="card-title"><strong>Palawan Express Padala</strong></h3>
                                    <h5 class="recipient"><strong>Recipient Name:</strong></h5>
                                    <p class="card-name">JOHN ED PAUL NUNEZ</p>

                                    <h5 class="recipient"><strong>Phone Number:</strong></h5>
                                    <p class="card-name">09324113225</p>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="{{asset('img/gcash.png')}}" class="card-img-top" style="height:230px;">
                                <div class="card-body">
                                    <h3 class="card-title"><strong>GCash</strong></h3>
                                    <h5 class="recipient"><strong>Recipient Name:</strong></h5>
                                    <p class="card-name">JOHN ED PAUL NUNEZ</p>

                                    <h5 class="recipient"><strong>Phone Number:</strong></h5>
                                    <p class="card-name">09324113225</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        
        <div class="form-group"> 
            <div class="col-md-2 float-end">
                <button class="btn btn-primary form-control">Finish</button> 
            </div>   
        </div>

        <div class="float-start">
            <a href="{{ route('user.enrollment') }}" class="btn btn-danger">Back</a>
        </div>
        
    </div>
    
</div>
