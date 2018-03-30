       
        {* modal delete *}
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Confirm
                        </h4>
                    </div>
                    <div class="modal-body">
                        Please confirm Deletion of:<br><br>
                        <div class="ucfirst" style="text-indent: 1cm;">
                            <modalDeleteType></modalDeleteType>&nbsp;<modalDeleteSpecific></modalDeleteSpecific>
                        </div>
                        <div style="text-indent: 1cm;">
                            <modalDeleteUrl></modalDeleteUrl>
                            <span class="hide"><deleteUrl></deleteUrl></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="modalBtnDelete" class="btn btn-danger" onclick="location.href=$('deleteUrl').text()">Delete</button>
                    </div>
                  </div>
            </div>
        </div>	
