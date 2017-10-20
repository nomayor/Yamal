from django import forms

class LoginForm(forms.Form):

    username = forms.CharField(
        max_length=100,
        widget=forms.TextInput,
        required=False,
        label="",
    )
    password = forms.CharField(
        max_length=100,
        widget=forms.TextInput,
        required=False,
        label="",
    )

    def clean(self):
        if self.cleaned_data.get('username') and self.cleaned_data.get('password'):
            self.user = authenticate(username=self.cleaned_data['username'], password=self.cleaned_data['password'])
            if self.user is None:
                raise forms.ValidationError('Please enter a correct username and password.')
            elif not self.user.is_active:  # or leave this out and handle inactive case in your view above.
                raise forms.ValidationError('This account is inactive.')
        return self.cleaned_data