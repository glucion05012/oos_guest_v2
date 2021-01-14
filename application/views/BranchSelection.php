        
        <!-- ks banner begin -->
        <div class="container-fluid branchSelectorContainer p-0 m-0"
        style='background:url("<?php echo base_url()."assets/images/Sogo-FNB-banner1-scaled.jpg";?>"); background-size:cover;
        background-position: center; background-repeat: no-repeat;'>
            <div class="col-lg-5 col-md-7 col-sm-9 col-11" style='position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>
            <h1 class="mb-3" style="text-align:center;color:white;">Branch Selection</h1>
                <form action="<?php echo base_url()."createsession?bcd=".$_GET['bcd']."&rmn=".$_GET['rmn'];?>" method="Post">
                    <div class="input-group mb-3 my-1 py-0">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Branches</label>
                        </div>
                        <select class="custom-select" id="selectedBranch" name="selectedBranch"  data-toggle='tooltip' data-placement='top' title='Select a branch here' required>
                            <?php foreach ($getBranches as $branch) : ?>
                                <?php if($_GET['bcd'] == $branch['code']): ?>
                                    <option value="<?php echo $branch['branch_id']; ?>">
                                        <?php echo $branch['name']; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach  ?>
                        </select>
                    </div>
                    <button class="btn s-primary-btn col-12 mb-2" type="submit" name="button" data-toggle='tooltip' data-placement='top' title='Proceed to ordering'>Next</button>
                    <div class="row" style="text-align:center;" data-toggle='tooltip' data-placement='top' title="Check your order's status ">
                        <a class="mx-auto" href="" style="color:white;"
                        data-toggle="modal" data-target="#trackOrderModal">Track my Order</a>  
                    </div>
                </form>
            </div>
        </div>
        <!-- banner end -->
                                
        <!-- Modal -->
        <div class="modal fade" id="trackOrderModal" tabindex="-1" aria-labelledby="tOModalTitle"
        aria-hidden="true">
            <form action="<?php echo base_url('track_order'); ?>" method="GET">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tOModalTitle">Track your order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- <label for="orderRefNo"></label> -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Order Ref. No.:</span>
                                </div>
                                <input type="text" class="form-control" id="orderRefNo" aria-describedby="basic-addon3"
                                name="orderRefNo">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn s-secondary-btn" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn s-primary-btn">Track Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- alert codes begin -->
        <div class='row p-0 m-0' style="position:fixed;top:20%;width:100%;" >
            <?php if($this->session->flashdata('successmsg')): ?>
                <div class="alert alert-danger px-5 my-2 mx-auto" role="alert">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <?php echo $this->session->flashdata('successmsg'); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- alert codes end -->    