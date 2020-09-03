<section class="testimonial py-5" id="testimonial">
    <div class="container">
        <div class="row ">
            <div class="col-md-3 py-5 bg-primary text-white text-center ">
                <div class=" ">
                    <div class="card-body">
                         <img src="<?php echo base_url('assets/images/registration.webp'); ?>" style="width:30%">
                        <h2 class="py-3">Registration</h2>
                        <p>Municipal Government of Los Baños Laguna Contact Tracing Site</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 py-5 border">
                <h4 class="pb-4">Please fill with your details</h4>
                <form>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="fname" name="fname" placeholder="First Name" class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="mname" name="mname" placeholder="Middle Name" class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="lname" name="lname" placeholder="Last Name" class="form-control" type="text">
                          </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                             </div>
                            <input id="address" name="address" placeholder="Address" class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                             </div>
                            <select class="form-control">
                              <option selected disabled>Select Barangay</option>
                              <option value="Anos">Anos</option>
                              <option value="Bagong Silang">Bagong Silang</option>
                              <option value="Bambang">Bambang</option>
                              <option value="Batong Malake">Batong Malake</option>
                              <option value="Baybayin">Baybayin</option>
                              <option value="Bayog">Bayog</option>
                              <option value="Lalakay">Lalakay</option>
                              <option value="Maahas">Maahas</option>
                              <option value="Malinta">Malinta</option>
                              <option value="Mayondon">Mayondon</option>
                              <option value="Tuntungin-Putho">Tuntungin-Putho</option>
                              <option value="San Antonio">San Antonio</option>
                              <option value="Tadlac">Tadlac</option>
                              <option value="Timugan">Timugan</option>
                            </select>
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                             </div>
                            <select class="form-control">
                              <option>Los Baños</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Birthday</span>
                            </div>
                            <input type="date" id="birthday" name="birthday" placeholder="Birthday" class="form-control" required="required" type="text">
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                            </div>
                            <input id="Mobile No." name="Mobile No." placeholder="Mobile No." class="form-control" required="required" type="text">
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="custom-file">
                            <input type="file" name="valid_id" onchange="readURL(this);"  id="inputGroupFile01" accept="image/*"/>
                            <label class="custom-file-label" for="inputGroupFile01">Choose file(Valid ID)</label>
                          </div>
                          <hr>
                          <div class='valid_id_display'>
                          </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                                  <label class="form-check-label" for="invalidCheck2">
                                    <small>By clicking Submit, you agree to our Terms & Conditions, and Privacy Policy.</small>
                                  </label>
                                </div>
                              </div>
                    
                          </div>
                    </div>
                    
                    <div class="form-row">
                        <button type="button" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.valid_id_display').html(`<img id="" src="${e.target.result}" alt="your image" height="75%" width="75%" />
`);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
