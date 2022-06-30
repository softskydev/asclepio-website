<style>
    .card-payment{
        padding: 20px 30px;
    }

    .rounded-md{
        border-radius: 15px;
    }

    .payment-image{
        max-width: 100px;
    }

    .text-13{
        font-size: 13px;
    }

    .text-14{
        font-size: 14px;
    }
    .fw-bold{
        font-weight: bold;
    }

    .text-underline{
        text-decoration: underline;
    }
    
    .rekening-payment{
        transition: .4s ease-in-out;
    }

    .rekening-payment:hover,.rekening-payment.active{
        box-shadow: 0px 0px 10px rgba(0, 0, 0, .3);
    }
</style>

<div class="w-100 px-md-5 px-3">
    <div class="row my-5 pt-5">
        <div class="col-md-8 col-12 mx-auto">
            <div class="card card-payment rounded-md shadow">
                <div class="header-card">
                    <div class=" text-center">
                        <h2>Aclepedia Bundling</h2>
                    </div>
                </div>
                <div class="body-card pt-md-4">
                    <form action="#" method="POST" id="form-bundling">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="full_name">Full name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_number">Number Phone</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="* * * * * * * * * * * " required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postcode">Post Code</label>
                                <input type="number" class="form-control" id="postcode" name="postcode" placeholder="* * * * * *" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="expedition"> Expedition</label>
                                <select class="form-control" id="expedition" name="expedition" required>
                                    <option  hidden>Select Expedition</option>
                                    <?php for ($i=1; $i < 6 ; $i++) {  ?>
                                        <option class="py-2" value="<?= $i?>">Ekspedisi<?= $i?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" rows="3" name="address" placeholder="Full Address"></textarea>
                            </div>
                            <div class="ml-auto px-3">
                                <button type="submit" class="btn btn-primary px-5 mt-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
